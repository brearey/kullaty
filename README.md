# Clear water delivery web app on PHP, MySQL

### Quickstart

- copy `example_db_connect.php` to `db_connect.php` and write login password MySQL
- run in server like [OpenServer](https://ospanel.io/)

### Demo

- Client [https://oktemsec.ru/water](https://oktemsec.ru/water)
- Admin panel [https://oktemsec.ru/water/admin](https://oktemsec.ru/water/admin)

### Deploy all files to prod
```bash
cd to/kullaty/folder
scp -r * gymoktem@gymoktem.myjino.ru:/home/users/g/gymoktem/domains/oktemsec.ru/water/
```

### Deploy the one file (index.php) to prod
```bash
cd to/kullaty/folder
scp index.php gymoktem@gymoktem.myjino.ru:/home/users/g/gymoktem/domains/oktemsec.ru/water/
```

### TODO:

- [ ] android app for dispatcher and driver
- [ ] android app with notification and connection to Database
- [ ] android app has the orders page with auto update
- [ ] web client app with auto update status
- [ ] Возможность изменения у водителя детали заказа (заказали два бутыля а по факту я отдал один бутыль)

> deadline: August 1, 2025