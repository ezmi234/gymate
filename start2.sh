#!/bin/bash

# Step 1: Start the Docker environment
vendor/bin/sail up -d

vendor/bin/sail npm run dev

# Step 7: Stop the Docker environment
vendor/bin/sail down