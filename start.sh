#!/bin/bash

# Step  1: Start the Docker environment
vendor/bin/sail up -d

# Step 2: Generate the application key
vendor/bin/sail php artisan key:generate

# Step 3: Run the database migrations
vendor/bin/sail php artisan migrate:fresh

# Step 4: Install npm dependencies
vendor/bin/sail npm i

# Step 5: Build the project
vendor/bin/sail npm run build

# Step 6: Run development build
vendor/bin/sail npm run dev

# Step 7: Stop the Docker environment
vendor/bin/sail down
