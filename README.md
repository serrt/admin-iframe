# admin-iframe
Laravel + AdminlLte + Iframe

## 网站管理

### RBAC

- users: username, name, password, remarks
- rols: name, key
- permissions(一个权限代表一个菜单): name, key, url
- user_roles: user_id, role_id
- role_permissions: role_id, permission_id

### 字典管理

- keywords_type: key, name
- keywords: p_key, key, name, sort

## 综治

### 户籍

#### 户籍人口

#### 户籍变动

- 迁入
- 迁出
- 分户
- 合户
- 出生
- 死亡

#### 人口统计

- 按**年份**和**社别**统计, 分别展示每个社别的男、女、总人数、 总户数, 再合计
- 有点麻烦, 需要过滤每年的`户籍变动`, 没有包括`非户籍人口`

#### 非户籍人口

##### 流动人口

##### 留守人口

##### 境外人口

#### 特殊人群

- 社区矫正人员
- 刑满释放人员
- 肇事肇祸精神病人
- 社区戒毒人员
- 重点青少年
- 上访信访人员
- 艾滋病危险人员
- 视频监控人员
- 视频监控报警

#### 困难人群

- 残疾人员
- 低保五保人员
- 失独家庭
- 失业人员
- 其他困难人员
