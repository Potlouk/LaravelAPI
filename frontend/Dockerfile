# Stage 1: Build the Angular application
FROM node:alpine as build

# Add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# Set working directory
WORKDIR /app

# Install app dependencies
COPY package.json package-lock.json ./
RUN npm install

# Install Angular CLI globally
RUN npm install -g @angular/cli

# Copy the rest of the application
COPY . .

# Build the Angular application
RUN ng build --configuration=production 

# Stage 2: Serve the application with Nginx
FROM nginx:alpine

# Copy the built assets from the build stage
COPY --from=build /app/dist/browser /usr/share/nginx/html

# Copy the custom Nginx configuration
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Expose port 80
EXPOSE 80

# Start Nginx server
CMD ["nginx", "-g", "daemon off;"]
