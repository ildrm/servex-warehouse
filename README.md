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

## Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 8.0 or PostgreSQL 13+ for target database
- Required PHP extensions:
  - PDO
  - MongoDB (optional, for MongoDB source support)
  - pgsql (optional, for PostgreSQL source support)

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
3. Configure your environment:
   ```bash
   cp .env.example .env
   ```
4. Generate application key:
   ```bash
   php artisan key:generate
   ```

## Configuration
1. Edit `.env` file to set up:
   - Database connections
   - Cache settings
   - Queue configuration
   - API security parameters

2. Configure source databases in `config/sources.php`
3. Set up target warehouse in `config/warehouse.php`

## Usage
- Start the service:
  ```bash
  php -S localhost:8000 -t public
  ```
- Access the API documentation at `http://localhost:8000/api/docs`

## API Documentation
### Available Endpoints
- `GET /extract` - Extract data from configured sources
  - Parameters:
    - source_id: string
    - tables: array
  - Returns: extraction_job_id

- `POST /transform` - Transform extracted data
  - Parameters:
    - extraction_job_id: string
    - transformations: array
  - Returns: transformation_job_id

- `POST /load` - Load transformed data into warehouse
  - Parameters:
    - transformation_job_id: string
    - target_tables: array
  - Returns: load_job_id

### Response Format
All endpoints return JSON with the following structure:
```json
{
    "status": "success|error",
    "message": "Operation description"
}
```

Complete API documentation is available in Swagger/OpenAPI format.

## Testing
- Run unit tests using PHPUnit:
  ```bash
  ./vendor/bin/phpunit
  ```
- Run integration tests:
  ```bash
  ./vendor/bin/phpunit --testsuite integration
  ```

## Deployment
1. Set up production environment
2. Configure web server (nginx/Apache)
3. Set up SSL certificates
4. Configure database backups
5. Set up monitoring

## Performance Optimization
- Enable PHP OPcache
- Configure Redis for caching
- Use queue workers for background processing
- Index warehouse tables properly

## Contributing
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security
- API authentication using JWT tokens
- Rate limiting implemented
- Input validation and sanitization
- Regular security audits
- HTTPS enforced in production

## Troubleshooting
- Check logs in `storage/logs`
- Verify database connections
- Ensure proper permissions
- Monitor memory usage

## License
This project is licensed under the MIT License.

## Support
- GitHub Issues for bug reports and feature requests
- Documentation wiki for detailed guides
- Community discussions in GitHub Discussions

## Changelog
See [CHANGELOG.md](CHANGELOG.md) for release history.

## Authors
- Initial work - [ildrm](https://github.com/ildrm)
