composer require Shaked/user-agents
mkdir ./tmp/
mv vendor/Shaked/user-agents/bin/php ./tmp/  2>/dev/null
rm -rf vendor/Shaked/user-agents/*
mv ./tmp/php/*.php vendor/Shaked/user-agents/  2>/dev/null
rm -rf ./tmp/