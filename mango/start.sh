#!/bin/bash

# Start MongoDB
mongod --fork --logpath /var/log/mongod.log --dbpath /data/db

# Set the environment variable for MongoDB URI
export MONGODB_URI=mongodb://localhost:27017/ctfDB

# Start the Node.js application
node index.js
