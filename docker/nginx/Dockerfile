# Use the official Nginx image
FROM nginx:latest

# Check if the default Nginx configuration file exists before attempting to remove it
RUN if [ -e /etc/nginx/conf.d/default.conf ]; then rm /etc/nginx/conf.d/default.conf; fi

# Copy your custom Nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Expose port 80
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]
