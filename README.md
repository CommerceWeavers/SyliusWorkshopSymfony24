<p align="center">
    <a href="https://sylius.com" target="_blank">
        <picture>
          <img alt="Sylius Logo" src="https://media.sylius.com/sylius-logo-800.png" height="100">
        </picture>
    </a>
    <a href="https://commerceweavers.com" target="_blank">
        <picture>
          <img alt="CW Logo" height="100" src="https://github.com/CommerceWeavers/SyliusWorkshopWarsaw24/blob/main/assets/images/cw-logo.png?raw=true">
        </picture>
    </a>
</p>

<h1 align="center">Sylius Workshop Warsaw 24'</h1>

<p align="center">This is repository for Sylius 2.0 Workshop that took place in Viena on 3rd of December 2024</p>

## Installation

### Traditional
Clone this project and execute following instruction
```bash
$ cd SyliusWorkshopSymfonyCon24
$ composer install 
$ yarn install
$ yarn build
$ php bin/console sylius:install
$ symfony serve
$ open http://localhost:8000/
```

For more detailed instruction please visit [installation chapter in our docs](https://docs.sylius.com/en/latest/book/installation/installation.html).

### Docker

#### Development

```bash
$ cp compose.override.dist.yml compose.override.yml
$ make setup
$ open http://localhost:9000/
```
