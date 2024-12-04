<?php

declare(strict_types=1);

namespace App\CommandHandler;

use App\Entity\Order\OrderItem;
use Sylius\Bundle\ApiBundle\Command\Cart\AddItemToCart;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class AddItemToCartHandler
{
    /**
     * @param OrderRepositoryInterface<OrderInterface> $orderRepository
     * @param ProductVariantRepositoryInterface<ProductVariantInterface> $productVariantRepository
     */
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ProductVariantRepositoryInterface $productVariantRepository,
        private OrderModifierInterface $orderModifier,
        private CartItemFactoryInterface $cartItemFactory,
        private OrderItemQuantityModifierInterface $orderItemQuantityModifier,
    ) {
    }

    public function __invoke(AddItemToCart $addItemToCart): OrderInterface
    {
        /** @var ProductVariantInterface|null $productVariant */
        $productVariant = $this->productVariantRepository->findOneBy(['code' => $addItemToCart->productVariantCode]);

        if ($productVariant === null) {
            throw new \InvalidArgumentException('Product variant with given code has not been found.');
        }

        /** @var OrderInterface|null $cart */
        $cart = $this->orderRepository->findCartByTokenValue($addItemToCart->orderTokenValue);

        if ($cart === null) {
            throw new \InvalidArgumentException('Cart with given token has not been found.');
        }

        /** @var OrderItem $cartItem */
        $cartItem = $this->cartItemFactory->createNew();
        $cartItem->setVariant($productVariant);
        $cartItem->setAmount($addItemToCart->amount);

        $this->orderItemQuantityModifier->modify($cartItem, $addItemToCart->quantity);
        $this->orderModifier->addToOrder($cart, $cartItem);

        return $cart;
    }
}
