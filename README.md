
## Setup application and enter shell
- `docker compose up -d`
- `docker exec -it ifx-php zsh`

## Run tests
- `composer test`

## Comment 
- Why do I use `bcmath` instead of normal multiplication? E.g.: ```var_dump(100 * 0.29);``` will return ```28.999999999999996```, not ```29```