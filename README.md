# Shipper List

## Requirements

1. Shipper
    1. Company name
    2. Address
2. Contact
    1. Name
    2. Contact number
    3. Is primary contact
    4. Shipper

## Developer Setup

```shell
echo "alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'" >> ~/.zshrc
source ~/.zshrc
sail up -d

sail artisan migrate:fresh --seed

# Run tests using 
sail test
```
open [shipper-list.localhost](http://shipper-list.localhost:8083)
