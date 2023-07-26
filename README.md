# new-dumping
parsing price12

Database structure
-------------------
//Данные в гугл листе, не хранятся в базе, но содержат данные
//Перехожу на таблицу зная менеджера и категорию
sku; seller; manager; link

//Таблица со ссылками на гугл листы
g_table
*******
id; manager_id; category_id; link; date

sellers+
*******
id; name

managers+
********
id; name

category+
********
id; name

sku
***
id; name

products???
********
id;name;sku

data_table
**********
id; category_id; sku_id; link; price; sellers_id; managers_id; date

