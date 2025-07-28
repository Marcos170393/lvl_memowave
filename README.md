<div align="center">
  <img src="./public/logo.png" alt="Logo" width="200"/>
</div>

<div align="center">
 <h1>Welcome to Memowave Backend</h1>
</div>

## Requirements

-   Docker installed on local machine.
-   Docker Compose to docker services management.

## Proyect configuration

1. **Clone repo:**

    ```bash
    git clone git@github.com:Marcos170393/lvl-memowave.git
    cd lvl-memowave
    ```

2. **Set `.env` variables:**

    Copy `.env.example` file to `.env`. Then, set needed environment variables.

    ```bash
    cp .env.example .env
    ```

3. **Build and run containers:**

    Run the following command to build docker images and run containers:
    `docker-compose.yml`.

    ```bash
    docker-compose up --build
    ```

4. **Install Laravel dependencies:**

    Once containers are up and runnning, run following command inside docker container:

    ```bash
    docker-compose exec -it lvl_memowave composer install
    ```
    Additionally, you will need install dependencies on proyect directory for a better developing experience
    (e.g VS Code extensions)
    ```bash
    compose install
    ```

5. **Generate App Key:**

    Generate Laravel App Key runnning:
    ```bash
    docker-compose exec -it lvl_memowave php artisan key:generate
    ```

6. **Run migrations:**

    Apply migrations on DataBase runnning the following command:
    ```bash
    docker-compose exec -it lvl_memowave php artisan migrate
    ```

7. **Create api client**

    To be able to consume lvl-memowave api, you need Api Clients Credentials (oAuth2). To do
    this, run following command:
     ```bash
    docker-compose exec -it lvl_memowave php artisan passport:client --personal
    ```
## Ready 🚀🚀

Finally, you'r be able to consume lvl-memowave using needed credentials on `http://localhost:8000/api/v1`.
For more information about how Laravel works, visit `https://laravel.com/docs` 😜

## Useful scripts

-   **Stop containers:**

    ```bash
    docker-compose down
    ```

-   **Restart containers:**

    ```bash
    docker-compose restart
    ```

# Thanks for visit Memowave 😊.

### 🤝 Keep in touch
- [LinkedIn](https://www.linkedin.com/in/marcos-correa-larrosa)
