create table order_tbl
(
    id                int unsigned auto_increment primary key,
    external_id       varchar(16) charset utf8            null,
    status_id         smallint unsigned                   not null,
    status_updated_at timestamp default CURRENT_TIMESTAMP not null,
    created_at        timestamp default CURRENT_TIMESTAMP not null
);

create table sys_order_status
(
    id         smallint unsigned auto_increment primary key,
    title      text charset utf8                   not null,
    created_at timestamp default CURRENT_TIMESTAMP not null
);

create table order_status_log_uniq
(
    id         int unsigned auto_increment primary key,
    order_id   int unsigned                        not null,
    status_id  smallint unsigned                   not null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    constraint uniq
        unique (order_id, status_id),
    constraint order_status_log_uniq_ibfk_1
        foreign key (order_id) references order_tbl (id)
            on update cascade,
    constraint order_status_log_uniq_ibfk_2
        foreign key (status_id) references sys_order_status (id)
            on update cascade
);

create index index__created_at
    on order_status_log_uniq (created_at);

create index order_id
    on order_status_log_uniq (order_id);

INSERT INTO sys_order_status (title) VALUES ('New'), ('Processing'), ('Completed');

INSERT INTO order_tbl (external_id, status_id) VALUES ('ABC123', 3), ('DEF456', 2), ('GHI789', 3), ('JKL012', 2), ('MNO345', 2);

INSERT INTO order_status_log_uniq (order_id, status_id, created_at)
VALUES (1, 1, '2023-01-01 00:00:00'),
       (1, 2, '2023-01-02 00:00:00'),
       (1, 3, '2023-01-03 00:00:00'),
       (2, 1, '2023-01-01 00:00:00'),
       (2, 2, '2023-01-02 00:00:00'),
       (3, 1, '2023-01-01 00:00:00'),
       (3, 2, '2023-01-02 00:00:00'),
       (3, 3, '2023-01-03 00:00:00'),
       (4, 1, '2023-01-01 00:00:00'),
       (4, 2, '2023-01-02 00:00:00'),
       (5, 1, '2023-01-01 00:00:00'),
       (5, 2, '2023-01-02 00:00:00');

/*
 Задача 1:
Вывести ID заказа, название статуса на заказе, название предпоследнего статуса выставленного на заказе и его время
ID;Current title status;Prelast title status;Prelast date status
112;Status 1;Status 2;2022-01-01 00:00:00
*/


SELECT DISTINCT(o.id) AS 'Order ID',
   s.title AS 'Current title status',
   ps.title AS 'Prelast title status',
   oslu2.created_at AS 'Prelast date status'
FROM order_tbl o
join order_status_log_uniq oslu on o.id = oslu.order_id
join sys_order_status s on oslu.status_id = s.id
join order_status_log_uniq oslu2 on o.id = oslu2.order_id
join sys_order_status ps on oslu2.status_id = ps.id
WHERE oslu.created_at = (SELECT MAX(created_at) FROM order_status_log_uniq WHERE order_id = o.id)
  AND oslu2.created_at = (SELECT MAX(created_at) FROM order_status_log_uniq WHERE order_id = o.id AND created_at < oslu.created_at)
  ORDER BY o.id;




/*
Задача 2:
Вывести с группировкой по дням, сколько заказов прошли через статус 1, сколько из этих заказов прошли статус 2, сколько из этих заказов имеют статус 3
Date of status 1; Total status 1; Total status 2; Total status 3;
2022-01-01;20;10;12
*/

SELECT DATE(os.created_at) AS 'Date of status 1',
       COUNT(DISTINCT CASE WHEN os.status_id = 1 THEN os.order_id END) AS 'Total status 1',
       COUNT(DISTINCT CASE WHEN os.status_id = 2 THEN os.order_id END) AS 'Total status 2',
       COUNT(DISTINCT CASE WHEN os.status_id = 3 THEN os.order_id END) AS 'Total status 3'
FROM order_status_log_uniq os
GROUP BY DATE(os.created_at);


