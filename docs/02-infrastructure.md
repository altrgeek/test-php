# The infrastructure

The current infrastructure is deployed on [Google Cloud Platform](https://cloud.google.com) with 3 dedicated services being used. Following are the services used to run the application.

1. A [Compute Engine](https://cloud.google.com/compute) VM for hosting Laravel portal web application, Flask AI emotion detection API and the websocket server.
2. A [Could SQL](https://cloud.google.com/sql) MySQL instance for storing relational data for portal web application.
3. A Redis instance on [Cloud Memorystore](https://cloud.google.com/memorystore) for storing application cache and processing queues for application and websocket server.
4. A [Cloud DNS](https://cloud.google.com/dns) zone for managing DNS configuration for our primary domain.
