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
| `apikey` | ✔️ | Official API-Key generated in OSTicket System |

## Check IP Authorization
To use the API from a specific IP Address, go to `ost_wbs > config.php` and set `API KEY RESTRICT` to `True`

## Request Structure
All requests must have the following structure.

| Type | format | Description |
| --- | --- |  :-: |
| `header`| default | Authentication |
| `body`| json | Parameters |

Output format: `json`

<br>

## 🔵 Ticket

## 🟡 `[GET]` Ticket/Specific

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
| `query`| `string` | `ticket` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✔️ | Indicates the condition of the request |
| `parameters` > `id`| `int` or `string` | `ID` or `Number` | ✔️ | Indicates specific ID or Number |


## 🟡 `[GET]` Ticket/Status 

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
| `query`| `string` | `ticket` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |
| `sort`|  `string` | `status` | ✔️ | Indicates the type of search |
| `parameters` > `status` | `int` | `Ticket Status ID` | ✔️ | Ticket status ID you want to search for |

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

## 🟡 `[GET]` Ticket/Creation Date

Fetch all tickets by creation between two given dates.

```javascript
{
"query":"ticket",
"condition":"all",
"sort": "creationDate",
"parameters":{
    "start_date":"1990-01-01 00:00:00",
    "end_date":"2022-06-17 23:59:59"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `ticket` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✔️ | Indicates the type of search |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✔️ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✔️ | End date  |

## 🟡 `[GET]` Ticket/Creation Date by Status

Fetch all tickets by creation between two given dates and by status.

```javascript
{
"query":"ticket",
"condition":"all",
"sort": "status",
"parameters":{
    "status":1,
    "start_date":"1990-01-01 00:00:00",
    "end_date":"2022-06-17 23:59:59"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `ticket` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |
| `sort`|  `string` | `statusByDate` | ✔️ | Indicates the type of search |
| `parameters` > `status`| `int` | `Ticket Status ID` | ✔️ | Ticket Status  |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✔️ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✔️ | End date  |

## 🔵 User

## 🟡 `[GET]` User/Specific

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
| `query`| `string` | `user` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✔️ | Indicates the condition of the request |
| `parameters` > `id`| `int` | `User ID` | ✔️ | Indicates specific ID |

## 🟡 `[GET]` User/Creation Date
Fetch all user by creation between two given dates.

```javascript
{
"query":"user",
"condition":"all",
"sort": "creationDate",
"parameters":{
    "start_date":"1990-01-01 00:00:00",
    "end_date":"2022-06-17 23:59:59"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `user` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✔️ | Indicates the type of search |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✔️ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✔️ | End date  |

## 🔵 Department

## 🟡 `[GET]` Department/Specific

Fetch all info from a specific deparment using the ID.

```javascript
{
"query":"department",
"condition":"specific",
"parameters":{
    "id":1
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `department` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✔️ | Indicates the condition of the request |
| `parameters` > `id`| `int` | `Department ID` | ✔️ | Department ID |

## 🟡 `[GET]` Department/Creation Date

Fetch all departments by creation between two given dates.

```javascript
{
"query":"department",
"condition":"all",
"sort": "creationDate",
"parameters":{
    "start_date":"1990-01-01 00:00:00",
    "end_date":"2022-06-17 23:59:59"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `department` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✔️ | Indicates the type of search |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✔️ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✔️ | End date  |

## 🟡 `[GET]` Department/Name

Fetch all info from published top level departments sorted by name.

```javascript
{
"query":"department",
"condition":"all",
"sort": "name"
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `department` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |
| `sort`|  `string` | `name` | ✔️ | Indicates the type of search |


## 🔵 SLA

## 🟡 `[GET]` SLA/Specific

Fetch all info from a specific sla using the ID.

```javascript
{
"query":"sla",
"condition":"specific",
"parameters":{
    "id":1
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `sla` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✔️ | Indicates the condition of the request |
| `parameters` > `id`| `int` | `SLA ID` | ✔️ | SLA ID |

## 🟡 `[GET]` SLA/Creation Date

Fetch all departments by creation between two given dates.

```javascript
{
"query":"sla",
"condition":"all",
"sort":"creationDate",
"parameters":{
    "start_date":"1990-01-01 00:00:00",
    "end_date":"2022-06-17 23:59:59"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `sla` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |
| `sort`|  `string` | `creationDate` | ✔️ | Indicates the type of search |
| `parameters` > `start_date`| `string` | `YYYY/MM/DD` | ✔️ | Start date  |
| `parameters` > `end_date`| `string` | `YYYY/MM/DD` | ✔️ | End date  |

## 🟡 `[POST] [PUT]` SLA/Add

Add new data to database

```javascript
{
"query":"sla",
"condition":"add",
"parameters":{
    "name":"SLA Name",
    "flags":1,
    "grace_period":1,
    "schedule_id":1,
    "notes": "This is a note"
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `sla` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `add` | ✔️ | Indicates the condition of the request |
| `parameters` > `name`| `string` | `Name` | ✔️ | SLA ID |
| `parameters` > `flags`| `int` | `Status` / `Transient` / `Ticket Overdue Alerts` | ✔️ | Flag Status |
| `parameters` > `grace_period`| `int` | `Grace Period` | ✔️ | Grace Period |
| `parameters` > `schedule_id`| `int` | `Shedule` | ✔️ | Shedule |
| `parameters` > `notes`| `string` | `Notes` | ✔️ | Notes |

## 🟡 `[DELETE]` SLA/Delete

Delete data from database

```javascript
{
"query":"sla",
"condition":"delete",
"parameters":{
    "id":1
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `sla` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `delete` | ✔️ | Indicates the condition of the request |
| `parameters` > `id`| `int` | `SLA ID` | ✔️ | SLA ID |

## 🔵 FAQ

## 🟡 `[GET]` FAQ/All

Fetch faq info from all categories.

```javascript
{
"query":"faq",
"condition":"all"
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `faq` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `all` | ✔️ | Indicates the condition of the request |

## 🟡 `[GET]` FAQ/Specific Category

Fetch faq info from a specific category, for example:

```javascript
{
"query":"faq",
"condition":"specific",
"parameters":{
    "id":1
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✔️ | Official API-Key generated in OSTicket System |
| `query`| `string` | `faq` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✔️ | Indicates the condition of the request |
| `parameters` > `id`| `int` | `Category ID` | ✔️ | Category ID |

## 🔵 Topic

## 🟡 `[GET]` Topic/All

Fetch all topics.

```javascript
{
"query":"topics",
"condition":"all"
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `apikey`| `string` | API-Key |  ✔️ | Official API-Key generated in OSTicket System |
| `query`| `string` | `topic` | ✔️ | Indicates the content of the request |

## 🟡 `[GET]` Topic/Specific

Fetch info for a specific topic.

```javascript
{
"query":"topics",
"condition":"specific",
"parameters":{
    "id":1
    }
}
```

| Option | Type | value | Mandatory | Description
| --- | --- |  :-: | :-: |  --- |
| `query`| `string` | `topic` | ✔️ | Indicates the content of the request |
| `condition`| `string` | `specific` | ✔️ | Indicates the condition of the request |
| `parameters` > `id`| `int` | `Topic ID` | ✔️ | Topic ID |
