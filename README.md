# Microservice-Based Data Collection and Reporting Service

## Overview
This service is designed to collect data from various databases (MySQL, PostgreSQL, MongoDB, etc.), store it in a unified structure, and provide advanced reporting capabilities. It is implemented using the ildrm/servex-php microservice framework.

## Project Structure
- **config/**: Configuration files for connecting to source and target databases.
- **src/**
  - **ETL/**: Modules for data extraction, transformation, and loading.
  - **models/**: Data models defining the schema of the data.
  - **services/**: Services for data extraction, storage, and reporting.
  - **controllers/**: RESTful controllers providing APIs.
- **tests/**: Unit tests for critical components.

## Features
- **Data Extraction**: Connects to various databases and extracts data.
- **Data Transformation**: Standardizes data formats for consistency.
- **Data Storage**: Stores unified data in a target database.
- **Reporting**: Provides APIs for generating dynamic reports with filtering, grouping, and pivoting capabilities.
- **Integration**: Outputs compatible with reporting tools like Power BI.

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/ildrm/servex-warehouse.git
   cd servex-warehouse
   ```
2. Install dependencies:
   ```bash
   composer install
   ```

## Usage
- Start the service:
  ```bash
  php -S localhost:8000 -t public
  ```
- Access the API documentation at `http://localhost:8000/api/docs`.

## API Documentation
- The API follows RESTful principles and provides endpoints for data extraction, reporting, and more.
- Documentation is available in Swagger/OpenAPI format.

## Testing
- Run unit tests using PHPUnit:
  ```bash
  ./vendor/bin/phpunit
  ```

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for discussion.

## License
This project is licensed under the MIT License.
