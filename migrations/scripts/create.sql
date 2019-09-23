-- we don't know how to generate schema erp (class Schema) :(
create table attachment
(
  id int auto_increment
    primary key,
  url varchar(255) null,
  description varchar(255) null,
  hash varchar(255) null,
  is_deleted int default '0' null
)
  engine=InnoDB
;

create table brand
(
  id int auto_increment
    primary key,
  name varchar(255) null,
  is_deleted int default '0' null
)
  engine=InnoDB
;

create table category
(
  id int auto_increment
    primary key,
  name varchar(255) null,
  is_deleted int default '0' null
)
  engine=InnoDB
;

create table company
(
  id int auto_increment
    primary key,
  name varchar(255) null,
  is_deleted int default '0' null
)
  engine=InnoDB
;

create table customer
(
  id int auto_increment
    primary key,
  company_id int null,
  phone varchar(255) null,
  email varchar(255) null,
  meta text null,
  attachment_id int null,
  is_deleted int default '0' null,
  name varchar(255) null,
  constraint customer_company_id_fk
  foreign key (company_id) references company (id)
)
  engine=InnoDB
;

create index customer_company_id_fk
  on customer (company_id)
;

create table employee
(
  id int auto_increment
    primary key,
  name varchar(255) null,
  phone varchar(255) null,
  email varchar(255) null,
  meta text null,
  attachment_id int null,
  is_deleted int default '0' null
)
  engine=InnoDB
;

create table meta
(
  id int auto_increment
    primary key,
  table_ref varchar(255) null,
  field_name varchar(255) null,
  field_type varchar(255) null,
  is_deleted int default '0' null
)
;

create table project
(
  id int auto_increment
    primary key,
  customer_id int null,
  category_id int null,
  status smallint(6) null,
  date_begin datetime null,
  date_end datetime null,
  order_value double null,
  po_number varchar(255) null,
  notes text null,
  attachment_id int null,
  meta text null,
  is_deleted int default '0' null,
  priority smallint(6) null,
  name varchar(255) null,
  terms varchar(255) null,
  employee_id int null,
  constraint project_ibfk_1
  foreign key (customer_id) references customer (id),
  constraint project_ibfk_2
  foreign key (category_id) references category (id),
  constraint project_ibfk_3
  foreign key (attachment_id) references attachment (id),
  constraint project_employee_id_fk
  foreign key (employee_id) references employee (id)
)
  engine=InnoDB
;

create table invoice
(
  id int auto_increment
    primary key,
  project_id int null,
  code varchar(255) null,
  old_code varchar(255) null,
  ref varchar(255) null,
  description varchar(255) null,
  quantity double null,
  price double null,
  itl_price double null,
  inv_ref varchar(255) null,
  se_ref varchar(255) null,
  order_status varchar(255) null,
  fob_cost varchar(255) null,
  fob_itl varchar(255) null,
  price_usd double null,
  is_deleted int default '0' null,
  brand_id int null,
  constraint invoice_project_id_fk
  foreign key (project_id) references project (id),
  constraint invoice_brand_id_fk
  foreign key (brand_id) references brand (id)
)
  engine=InnoDB
;

create index invoice_brand_id_fk
  on invoice (brand_id)
;

create index invoice_project_id_fk
  on invoice (project_id)
;

create index attachment_id
  on project (attachment_id)
;

create index category_id
  on project (category_id)
;

create index customer_id
  on project (customer_id)
;

create index project_employee_id_fk
  on project (employee_id)
;

create table project_expense
(
  id int auto_increment
    primary key,
  project_id int null,
  employee_id int null,
  date_expense datetime null,
  order_ref varchar(255) null,
  expense_code varchar(255) null,
  order_amount double null,
  meta text null,
  remark text null,
  is_deleted int default '0' null,
  constraint project_expense_project_id_fk
  foreign key (project_id) references project (id),
  constraint project_expense_employee_id_fk
  foreign key (employee_id) references employee (id)
)
  engine=InnoDB
;

create index project_expense_employee_id_fk
  on project_expense (employee_id)
;

create index project_expense_project_id_fk
  on project_expense (project_id)
;

create table project_payment
(
  id int auto_increment
    primary key,
  project_id int null,
  method varchar(255) null,
  amount double null,
  CRVRef varchar(255) null,
  due_date datetime null,
  due_amount double null,
  meta text null,
  is_deleted int default '0' null,
  date_payment datetime null,
  constraint project_payment_project_id_fk
  foreign key (project_id) references project (id)
)
  engine=InnoDB
;

create index project_payment_project_id_fk
  on project_payment (project_id)
;

create table supplier
(
  id int auto_increment
    primary key,
  name varchar(255) null,
  phone varchar(255) null,
  email varchar(255) null,
  meta text null,
  company_id int null,
  attachment_id int null,
  is_deleted int default '0' null,
  constraint supplier_company_id_fk
  foreign key (company_id) references company (id)
)
  engine=InnoDB
;

create table procurement
(
  id int auto_increment
    primary key,
  project_id int null,
  supplier_id int null,
  brand_id int null,
  value double null,
  value_usd double null,
  fctr varchar(255) null,
  se_cost varchar(255) null,
  pr varchar(255) null,
  type varchar(255) null,
  terms varchar(255) null,
  po_ref varchar(255) null,
  po_date datetime null,
  se varchar(255) null,
  se_status varchar(255) null,
  is_deleted int default '0' null,
  constraint procurement_project_id_fk
  foreign key (project_id) references project (id),
  constraint procurement_supplier_id_fk
  foreign key (supplier_id) references supplier (id),
  constraint procurement_brand_id_fk
  foreign key (brand_id) references brand (id)
)
  engine=InnoDB
;

create index procurement_brand_id_fk
  on procurement (brand_id)
;

create index procurement_project_id_fk
  on procurement (project_id)
;

create index procurement_supplier_id_fk
  on procurement (supplier_id)
;

create table procurement_payment
(
  id int auto_increment
    primary key,
  procurement_id int null,
  amount double null,
  date datetime null,
  is_deleted int default '0' null,
  constraint procurement_payment_procurement_id_fk
  foreign key (procurement_id) references procurement (id)
)
  engine=InnoDB
;

create index procurement_payment_procurement_id_fk
  on procurement_payment (procurement_id)
;

create index supplier_company_id_fk
  on supplier (company_id)
;

create table user
(
  id int auto_increment
    primary key,
  username varchar(255) not null,
  password varchar(255) not null,
  email varchar(255) not null,
  first_name varchar(255) not null,
  last_name varchar(255) not null,
  type int not null,
  is_deleted bit default b'0' not null,
  DateAdded timestamp default CURRENT_TIMESTAMP not null
)
  engine=InnoDB collate=utf8_bin
;

