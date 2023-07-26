API GS
AIzaSyC1iJNUPx-RTkmMCFrgS8g7rrllztElTf4
AIzaSyC1iJNUPx-RTkmMCFrgS8g7rrllztElTf4
https://www.youtube.com/watch?v=zoufwxZjr0c

api_key = AIzaSyC1iJNUPx-RTkmMCFrgS8g7rrllztElTf4
client_id = 1047121742164-58l6gu40f7dll3glocgsgig0cg13d359.apps.googleusercontent.com
client_secret = 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


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

