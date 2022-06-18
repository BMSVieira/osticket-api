<p align="center">
 <img width="400" src="https://bmsvieira.github.io/osticket-api/images/logo.png">
 <br><br>
 Welcome to the unofficial OSTicket API!<br><br>
 The purpose of this API is to help the community and leverage the use of OSTicket.<br>
 For more info, please go to their official website: https://osticket.com/
</p>

## How to Use
To use OSTicket Unofficial API you have to place the `ost_wbs` directory in the root of OSTicket server. <br>
Then, go to `ost_wbs > config.php` and change the `DB credentials` and the `table prefix`.

Use the following base URL: 
```javascript
{YOUR-DOMAIN}/upload/ost_wbs/
```

<b>NOTE</b>: If you dont know the credentials, go to `upload/include/ost-config.php`. That is the main config file for OSTicket system.

## Authentication
In all requests, the API key that was created in the OSTicket system must be sent in the `header` to authenticate the user.<br>

| Option | Mandatory | Description
| --- | :-: |  --- |
| `apikey` | ✅ | Official API-Key generated in OSTicket System |

## Check IP Authorization
To use the API from a specific IP Address, go to `ost_wbs > config.php` and set `API KEY RESTRICT` to `True`

## Request Structure
All request must have the following structure.

| Type | format | Description |
| --- | --- |  :-: |
| `header`| default | Authentication |
| `body`| json | Parameters |

Output format: `json`

<br>

## 🔶 Ticket

### 🔸 `[GET]` Specific
Fetch all info from a specific ticket using the ID or ID Number.

```javascript
{
"query":"ticket",
"condition":"specific",
"parameters":{
    "id":1
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters` > `id`| `int` or `string` | `ID` or `Number` | ✅ | Indicates specific ID or Number |


### 🔸 `[GET]` Status 
Fetch all tickets based on the current status.

```javascript
{
"query":"ticket",
"condition":"all",
"sort": "status",
"parameters":{
    "status":1
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `status` | ✅ | Indicates the type of search |
| `parameters` > `status` | `int` | `Ticket Status ID` | ✅ | Ticket status ID you want to search for |

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

### 🔸 `[GET]` Creation Date
Fetch all tickets by creation between two given dates.

```javascript
{
"query":"ticket",
"condition":"all",
"sort": "creationDate",
"parameters":{
    "start_date":"1990/01/01",
    "end_date":"2022/06/19"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✅ | Indicates the type of search |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✅ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✅ | End date  |

### 🔸 `[GET]` Creation Date by Status
Fetch all tickets by creation between two given dates and by status.

```javascript
{
"query":"ticket",
"condition":"all",
"sort": "status",
"parameters":{
    "status":1,
    "start_date":"1990/01/01",
    "end_date":"2022/06/19"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `ticket` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `statusByDate` | ✅ | Indicates the type of search |
| `parameters` > `status`| `int` | `Ticket Status ID` | ✅ | Ticket Status  |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✅ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✅ | End date  |


## 🔶 User

### 🔸 `[GET]` Specific
Fetch all info from a specific user using the ID.

```javascript
{
"query":"user",
"condition":"specific",
"parameters":{
    "id":2
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `user` | ✅ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✅ | Indicates the condition of the request |
| `parameters` > `id`| `int` | `User ID` | ✅ | Indicates specific ID |

### 🔸 `[GET]` Creation Date
Fetch all user by creation between two given dates.

```javascript
{
"query":"user",
"condition":"all",
"sort": "creationDate",
"parameters":{
    "start_date":"1990/01/01",
    "end_date":"2022/06/18"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `user` | ✅ | Indicates the content of the request |
| `condition`| `string` | `all` | ✅ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✅ | Indicates the type of search |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✅ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✅ | End date  |

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
