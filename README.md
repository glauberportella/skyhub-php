[![Build Status](https://travis-ci.org/glauberportella/skyhub-php.svg?branch=master)](https://travis-ci.org/glauberportella/skyhub-php) [![Code Climate](https://codeclimate.com/github/glauberportella/skyhub-php/badges/gpa.svg)](https://codeclimate.com/github/glauberportella/skyhub-php) [![Test Coverage](https://codeclimate.com/github/glauberportella/skyhub-php/badges/coverage.svg)](https://codeclimate.com/github/glauberportella/skyhub-php/coverage)

#A PHP Library for SkyHub API

The purpose of this lib is to create an abstracted layer to facilitate the use of [SkyHub API](http://www.skyhub.com.br) by PHP developers.

**Actual stage**: Development - not yet functional

#CURL test integration

Data files in tests/data directory.

## Category

### POST
    curl -X POST -d @tests/data/category.json https://in.skyhub.com.br/categories -H "Accpet: application/json" -H "Content-Type: application/json" -H "X-User-Email: glauberportella@gmail.com" -H "X-User-Token: ynaS6bsf6q5GE21zj7Ay"