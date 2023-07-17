
# JobIT Better

Welcome on JobIT Better by Externatic repository ! This project is our 3rd project for Wild Code School, and was developped in 2 months by Alexandre, Aline, Maxime, Itaan and Kevin. You can find us in the "author" section down below.

The application is designed for companies to post job offers, and for users to apply to these job offers.


## Tech Stack

**Client:** Bootstrap, Twig, Webpack Encore

**Server:** PHP 8.2, Symfony 6.2, MySQL


## Installation

- Clone this repository

- Go the project directory
```bash
  cd the-project
  ```
- Open the project with your favorite code editor
- Create a .env.local file, which is a copy of the .env file but with your database informations

- Install dependencies

```bash
  composer install 
  yarn install 
  ```
  - Set up the local database 
  ```bash
  symfony console doctrine:database:create 
  symfony console doctrine:migrations:migrate 
  symfony console doctrine:fixtures:load 
```
- Start the local server
 ```bash
  symfony serve -d 
  yarn watch
```


## How to use the application

- As a company

You can sign in as a company with the "Accès recruteur" button, verify your e-mail and log in. You can then modify your informations, and post job offers. You can see which candidates did apply for your offers in the dedicated section in your profile and in your mailbox.

- As a candidate 

You can sign in as a candidate with the 'S'inscrire" button, verify your e-mail and log in. You can then modify your informations, upload resumes or set up a research filter which will send you a notification when a job offer matching your criterias is posted by a company. You can also look for job offers with the search bar on the home page, and apply at the bottom of the page.

- As an admin

There is also a working back-office for administrators, where they can manage everything on the application ( users, companies, job offers, ...).
## Authors

- [@Aline](https://github.com/Aline33)
- [@Itaan](https://github.com/ItaanS)
- [@Alex](https://github.com/Chadowww)
- [@Maxime](https://github.com/Mgg24)
- [@Kevin](https://github.com/KevinDavoust)

