<p align="center">
 <img width="400" src="https://bmsvieira.github.io/osticket-api/images/logo.png">
 <br><br>
 Welcome to the unofficial OSTicket API!<br><br>
 The purpose of this API is to help the community and leverage the use of OSTicket.<br>
 For more info, please go to their official website: https://osticket.com/
</p>

<p align="center">
------------------------------------------------------------------<br>
 ⚠️ v2.0.0 Coming soon! Major structural changes!⚠️<br>
------------------------------------------------------------------
</p>

## Tested Versions
This api was tested in the following OST versions:

| Version |
| --- |
| `v1.15.8`|
| `v1.15.3.1`|
| `v1.14.3`|

## How to Use
To use OSTicket Unofficial API you have to place the `ost_wbs` directory in the root of OSTicket server.<br>
Then, go to `ost_wbs > config.php` and change the `DB credentials` and the `table prefix`.

Use the following URL: 
```javascript
{YOUR-DOMAIN}/ost_wbs/?
```

<b>NOTE</b>: If you dont know the credentials, go to `/include/ost-config.php`. That is the main config file for OSTicket system.

## Authentication
In all requests, the API key that was created in the OSTicket system must be sent to authenticate the user.<br>

| Option | Type | Mandatory | Description
| --- | --- |  :-: |  --- |
| `apikey`| string | ✅ | Official API-Key generated in OSTicket System |

<b>Example</b>:

```javascript
{YOUR-DOMAIN}/ost_wbs/?apikey={API-KEY}
```

### Check IP Authorization
To use the API from a specific IP Address, go to `ost_wbs > config.php` and set `API KEY RESTRICT` to `True`

<br>

## 🟩 Ticket Info

### 🔷 Specific Ticket
You can fetch all info from a specific ticket using the ID or ID Number, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=ticket&condition=specific&parameters={TICKET-ID/TICKET-NUMBER}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters`| `int` or `string` | `ID` or `Number` | ✅ | Indicates specific ID or Number |


### 🔷 By Status 
You can fetch all tickets based on the current status, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=ticket&condition=all&sort=status&parameters={TICKET-STATUS-ID}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `status` | ✅ | Indicates the type of search |
| `parameters`| `int` or `string` | `Ticket Status ID` | ✅ | Ticket status ID you want to search for |

Available ticket status:

| Option | Name |
| --- | --- |
| `0`| `All` not necessarily a "state" but returns all tickets in the DB regardless of state |
| `1`| `Open` |
| `2`|  `Resolved` |
| `3`| `Closed` |
| `4`| `Archived` |
| `5`|  `Deleted` |
| `6`| `On Going` |
| `7`| `Pending` |

### 🔷 Between Dates
You can fetch all tickets by creation between two given dates, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=ticket&condition=all&sort=creationDate&parameters={START-DATEtoEND-DATE}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✅ | Indicates the type of search |
| `parameters`| `string` | `1990-01-01to2000-01-01` | ✅ | Date interval that all tickets will be fetched |

### 🔷 Between Dates by Status
You can fetch all tickets by creation between two given dates and by status, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=ticket&condition=all&sort=statusByDate&parameters={START-DATEtoEND-DATE},{TICKET-STATUS-ID}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `statusByDate` | ✅ | Indicates the type of search |
| `parameters`| `string` | `1990-01-01to2000-01-01`,`2` | ✅ | Date interval and status by wich all tickets will be fetched |


## 🟩 User Info

### 🔷 Specific User
You can fetch all info from a specific user using the ID, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=user&condition=specific&parameters={USER-ID}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `user` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters`| `int` | `User ID` | ✅ | Indicates specific ID |

### 🔷 Between Dates
You can fetch all user by creation between two given dates, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=user&condition=all&sort=creationDate&parameters={START-DATEtoEND-DATE}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `user` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✅ | Indicates the type of search |
| `parameters`| `string` | `1990-01-01to2000-01-01` | ✅ | Date interval that all users will be fetched |

## 🟩 Department Info

### 🔷 Specific Department
You can fetch all info from a specific deparment using the ID, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=department&condition=specific&parameters={DEPARTMENT-ID}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `department` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters`| `int` | `Department ID` | ✅ | Indicates specific ID |

### 🔷 Between Dates
You can fetch all departments by creation between two given dates, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=department&condition=all&sort=creationDate&parameters={START-DATEtoEND-DATE}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `department` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✅ | Indicates the type of search |
| `parameters`| `string` | `1990-01-01to2000-01-01` | ✅ | Date interval that all departments will be fetched |

### 🔷 By Name
You can fetch all info from published top level departments sorted by name, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=department&condition=all&sort=name
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `department` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `name` | ✅ | Indicates the type of search |


## 🟩 SLA Info

### 🔷 Specific SLA
You can fetch all info from a specific sla using the ID, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=sla&condition=specific&parameters={SLA-ID}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `sla` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters`| `int` | `SLA ID` | ✅ | Indicates specific ID |

### 🔷 Between Dates
You can fetch all departments by creation between two given dates, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=sla&condition=all&sort=creationDate&parameters={START-DATEtoEND-DATE}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `sla` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✅ | Indicates the type of search |
| `parameters`| `string` | `1990-01-01to2000-01-01` | ✅ | Date interval that all SLAs will be fetched |

## 🟩 Faq Info

### 🔷 All Categories
You can fetch faq info from all categories, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=faq&condition=all
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `faq` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |

### 🔷 Specific Category
You can fetch faq info from a specific category, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=faq&condition=specific&parameters={Category-ID}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `faq` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters`| `int` | `Category ID` | ✅ | Indicates specific ID |

## 🟩 Topic Info

### 🔷 All Topics
You can fetch topic info, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=topics&condition=all
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `topic` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |

### 🔷 Specific Topic
You can fetch info for a specific topic, for example:

```javascript
/ost_wbs/?apikey={API-KEY}&query=topics&condition=specific&parameters={Topic-ID}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✅ | Official API-Key generated in OSTicket System |
| `query`| `string` | `topic` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters`| `int` | `Topic ID` | ✅ | Indicates specific ID |
