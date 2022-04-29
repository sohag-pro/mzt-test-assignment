
# MyZenTeam code test assignment
 *Setup instructions are given below*

## Description

In this test assignment we have prepared a hiring platform where job seekers (candidates) can be found and get contacted and hired from companies' hiring managers.

The platform is free for job seekers, but not for companies.
The billing is handled by using a wallet. At the start each company has a wallet with 20 coins of credit.
These coins can be used to contact candidates and contacting a candidate will cost the company 5 coins.

On the candidates' list there is a button `Contact` and this is where a company can contact a candidate.
Similarly, the button `Hire` is where a company can hire a candidate.

One of the tasks for this test assignment is to implement the `Contact a candidate` feature which should consist of the following:
when a company contacts a candidate, we should send an email to that candidate and charge the company 5 coins from its wallet.

The other feature that is part of this test assignment is to `hire a candidate`.
When a company hires a candidate we should mark the candidate as `hired`, put back 5 coins in the wallet of the company, and send an email to the candidate to tell them they were hired.
A company can hire only candidates that they have contacted before.

Aside from the features, we're aware that this app is far from perfect, so we'd like you to fix/improve anything that you find to be wrong or needs improvement (code, architecture, naming, readability, robustness, etc.).

While doing this test assignment, please pay attention to these aspects:

- Security - we do not want to be hacked
- Best practices - code should be clean and easy to maintain
- Documentation - provide information on how to set up the project
- Tests - test the parts that you feel necessary to
- Logic - pay attention to the constraints throughout the test assignment

## Notes
- Authentication **IS NOT** in the scope of this assignment.
- The list of candidates, the company and the wallet are predefined and there is no need to create new ones.
- The emails that should be sent to the candidates can consist of only text, no design is needed.


# Get started

#### Cases covered in the test assignment
1. Company can not hire a candidate who they have not contacted before.
2. Company can not hire a candidate who has already been hired.
3. Company can not contact a candidate who has already been contacted.

## Minimum System Requirments
1. PHP 8+
2. composer 2
3. npm 8

## How to setup
1. Clone the repository
    ```
    git clone https://github.com/sohag-pro/mzt-test-assignment.git
    ```
2. Open the project folder
    ```
    cd mzt-test-assignment
    ```
3. Copy the .env.example to .env
    ```
    cp .env.example .env
    ```
4. Create a new Database and add credentials in `.env`

5. Download php dependency with composer
    ```
    composer install
    ```
6. Download JS dependency with npm
    ```
    npm install
    ```
7. Run npm run watch (While developing)
    ```
    npm run watch
    ```
8. Run npm run prod (Need to run each time you push the code to production)
    ```
    npm run prod
    ```
9. Run this command to create databse tables and seed data
    ```
    php artisan migrate:fresh --seed
    ``` 
10. Run this command to generate the app key
    ```
    php artisan key:generate
    ```
11. Run this command to start the server (While developing or running on local server)
    ```
    php artisan serve
    ```
12. Run this command to start the queue listener (Needed to send emails)
    ```
    php artisan queue:listen
    ```



### Note:
If you want to add something in CSS or JS,
Please add them in `resources\css\app.css` and `resources\js\app.js`
And then run `npm run dev` or `npm run prod`
