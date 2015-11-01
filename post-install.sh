mkdir ./tmp/
mv vendor/Shaked/user-agents/bin/php ./tmp/
rm -rf vendor/Shaked/user-agents/*
mv ./tmp/php/*.php vendor/Shaked/user-agents/
rm -rf ./tmp/