-- we don't know how to generate schema erp (class Schema) :(
create table attachment
(
  id int auto_increment
    primary key,
  owner varchar(255) null,
  path varchar(255) null,
  is_deleted int default '0' null,
  owner_id int null
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
  name varchar(255) null,
  email varchar(255) null,
  address varchar(255) null,
  attachment_id int null,
  city varchar(255) null,
  phone varchar(255) null,
  zip varchar(255) null,
  country varchar(255) null,
  state varchar(255) null,
  meta text null,
  is_deleted int default '0' null,
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
  employee_id int null,
  name varchar(255) null,
  date_end date null,
  date_begin date null,
  po_number varchar(255) null,
  terms varchar(255) null,
  attachment_id int null,
  meta text null,
  status smallint(6) null,
  priority smallint(6) null,
  order_value double null,
  notes text null,
  etc date null,
  is_deleted int default '0' null,
  constraint project_ibfk_1
  foreign key (customer_id) references customer (id),
  constraint project_ibfk_2
  foreign key (category_id) references category (id),
  constraint project_employee_id_fk
  foreign key (employee_id) references employee (id),
  constraint project_ibfk_3
  foreign key (attachment_id) references attachment (id)
)
  engine=InnoDB
;

create table invoice_item
(
  id int auto_increment
    primary key,
  project_id int null,
  brand_id int null,
  code varchar(255) null,
  old_code varchar(255) null,
  description varchar(255) null,
  quantity double null,
  price double null,
  price_ttl double null,
  orc_ref varchar(255) null,
  se_ref varchar(255) null,
  order_status varchar(255) null,
  fob_cost double null,
  fob_ttl double null,
  currency varchar(255) null,
  is_deleted int default '0' null,
  orc_cost double null,
  orc_ttl double null,
  pft int null,
  sup_ref varchar(255) null,
  constraint invoice_project_id_fk
  foreign key (project_id) references project (id),
  constraint invoice_brand_id_fk
  foreign key (brand_id) references brand (id)
)
  engine=InnoDB
;

create index invoice_brand_id_fk
  on invoice_item (brand_id)
;

create index invoice_project_id_fk
  on invoice_item (project_id)
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
  date_expense date null,
  order_ref varchar(255) null,
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
  date_payment date null,
  crv_ref varchar(255) null,
  inv_value double null,
  inv_ref varchar(255) null,
  inv_date date null,
  due_amount double null,
  due_date date null,
  meta text null,
  is_deleted int default '0' null,
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
  currency varchar(255) null,
  se varchar(255) null,
  se_fctr double null,
  se_status varchar(255) null,
  se_cost double null,
  terms varchar(255) null,
  po_ref varchar(255) null,
  po_date date null,
  inv_ref varchar(255) null,
  pr varchar(255) null,
  type varchar(255) null,
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
  meta text null
)
  engine=InnoDB collate=utf8_bin
;

