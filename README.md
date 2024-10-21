
## Setup application and enter shell
1. docker compose up -d
2. docker exec -it ifx-php zsh

## Comment 
- Why do I use bcmath instead of normal multiplication? E.g.: ```var_dump(100 * 0.29);``` will return ```float(28.999999999999996)```, not 29