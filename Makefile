build:
	composer install
	npm install
	npm run build

deploy_migrations:
	php bin/console doctrine:migrations:migrate

install: build deploy_migrations

clean: 
	rm -Rf node_modules
	rm -Rf var
	rm -Rf vendor
	rm -Rf public/build
	rm -Rf public/bundles

# For node dev env
node_watch:
	npm run watch