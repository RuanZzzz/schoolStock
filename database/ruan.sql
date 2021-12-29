-- 物品信息表
create table school_stock.goods
(
    id            int auto_increment,
    company       varchar(255) null comment '供货商',
    name          varchar(255) null,
    specification varchar(255) null comment '规格',
    unit          varchar(255) null comment '单位',
    price         float        null,
    cate          varchar(255) null,
    remark        varchar(255) null,
    created_at    varchar(255) null,
    constraint goods_id_uindex
        unique (id)
)
    comment '物品信息表';

alter table school_stock.goods
    add primary key (id);

-- 库存表
create table school_stock.stock
(
    id         int auto_increment,
    goods_id   int           not null,
    count      int default 0 null,
    updated_at varchar(255)  null,
    created_at varchar(255)  null,
    constraint stock_id_uindex
        unique (id)
);

alter table school_stock.stock
    add primary key (id);




-- 出库入库记录表
create table school_stock.record
(
    id                int auto_increment,
    goods_id          int          not null,
    goods_count       int          null comment '入库/出库数量',
    goods_price       float        null comment '物品单价',
    goods_total_price float        null comment '此次物品的总价',
    record_time       varchar(255) null comment '入库/出库的时间，需要手动设置',
    created_at        varchar(255) null comment '数据的创建时间',
    opera_type        varchar(255) not null comment '操作类型',
    record_name       varchar(255) not null comment '操作人名称',
    remark            varchar(255) null,
    constraint record_id_uindex
        unique (id)
)
    comment '操作记录表';

alter table school_stock.record
    add primary key (id);




