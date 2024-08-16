if [ ! -f "./vendor/bin/sail" ]; then
  echo "ERROR: Laravel Sail script not found. Make sure you've run 'composer install'."
  exit 1
fi

# Define a shell function for Sail
function sail {
  ./vendor/bin/sail "$@"
}

# Function to run a Laravel artisan command and display a result message
function run_laravel_command {
  command="$1"
  description="$2"
  sail artisan "$command"
  if [ $? -eq 0 ]; then
    echo "✔️ $description completed successfully."
  else
    echo "❌ $description failed."
    exit 1
  fi
}


run_laravel_command "config:clear" "Clearing the config"

run_laravel_command "cache:clear" "Clearing the cache"

run_laravel_command "route:clear" "Clearing the application routes"

# Display a message indicating the end of Laravel commands
echo "✅ Laravel commands completed successfully."
