Примеры запросов и ответов postman

МЕТОД GET
ЗАПРОС http://yiiapi/api/web/v1/requests
ОТВЕТ {
    "success": true,
    "data": [
        {
            "id": "1",
            "name": "test",
            "email": "test@test.ru",
            "status": "active",
            "message": "проверка задачи",
            "comment": null,
            "created_at": "2023-08-22 00:00:00",
            "updated_at": "0000-00-00 00:00:00"
        },
        {
            "id": "2",
            "name": "subziro",
            "email": "trust@gmail.com",
            "status": "resolved",
            "message": "проверка даты и времени",
            "comment": "все работает",
            "created_at": "2023-08-22 11:05:56",
            "updated_at": "2023-08-22 11:11:23"
        },
        {
            "id": "4",
            "name": null,
            "email": null,
            "status": "resolved",
            "message": null,
            "comment": null,
            "created_at": "2023-08-22 11:07:47",
            "updated_at": "2023-08-22 11:08:54"
        },
        {
            "id": "5",
            "name": null,
            "email": null,
            "status": "active",
            "message": null,
            "comment": null,
            "created_at": "2023-08-22 18:49:24",
            "updated_at": "0000-00-00 00:00:00"
        }
    ]
}

запрос http://yiiapi/api/web/v1/requests/12
ответ {
    "success": true,
    "data": {
        "id": "12",
        "name": "testing",
        "email": "gnom@mail.ru",
        "status": "active",
        "message": "\"проверка встаки новой задачи с пробелами\"",
        "comment": null,
        "created_at": "2023-08-22 19:22:27",
        "updated_at": "0000-00-00 00:00:00"
    }
}

запрос http://yiiapi/api/web/v1/requests/12212121
ответ {
    "success": true,
    "data": null
}


запрос http://yiiapi/api/web/v1/requests/12zxczxczxcvadxcvasd
ответ {
    "success": false,
    "error": "Номера заявок имеют только цифры",
    "param": {
        "id": "12zxczxczxcvadxcvasd"
    },
    "method": "GET"
}
фильтрация по статусу (active, resolved)
запрос http://yiiapi/api/web/v1/requests?filter=active
ответ {
    "success": true,
    "data": [
        {
            "id": "1",
            "name": "test",
            "email": "test@test.ru",
            "status": "active",
            "message": "проверка задачи",
            "comment": null,
            "created_at": "2023-08-22 00:00:00",
            "updated_at": "0000-00-00 00:00:00"
        },
        {
            "id": "13",
            "name": "div",
            "email": "gnoxm@mail.ru",
            "status": "active",
            "message": "тестовая проверка",
            "comment": null,
            "created_at": "2023-08-22 19:48:43",
            "updated_at": "0000-00-00 00:00:00"
        }
    ]
}


МЕТОД POST
запрос http://yiiapi/api/web/v1/requests?name=testing&&email=gnom@mail.ru
ответ {
    "success": false,
    "error": "Для обработки задачи требуется имя и email пользователя, а также сообщение",
    "param": {
        "name": "testing",
        "email": "gnom@mail.ru"
    },
    "method": "POST"
}

запрос http://yiiapi/api/web/v1/requests?name=div&&email=gnoxm@mail.ru&&message=тестовая проверка
ответ {
    "success": true,
    "data": "Задача с номером 13 создана."
}



МЕТОД PUT
запрос http://yiiapi/api/web/v1/requests/13?comment=проверка 13
ответ {
    "success": true,
    "data": "ok"
   }
   
запрос http://yiiapi/api/web/v1/requests/13
ответ {
    "success": false,
    "error": "Для ответа на конкретную задачу требуется id задачи и заполненый комментарий",
    "param": {
        "id": "13"
    },
    "method": "PUT"
}

запрос http://yiiapi/api/web/v1/requests
ответ{
    "success": false,
    "error": "Для ответа на конкретную задачу требуется id задачи и заполненый комментарий",
    "param": [],
    "method": "PUT"
}   

МЕТОД DELETE
запрос http://yiiapi/api/web/v1/requests
ответ {
    "success": false,
    "error": "Для удаления требуется id записи",
    "param": [],
    "method": "DELETE"
}

запрос http://yiiapi/api/web/v1/requests/123214214
ответ {
    "success": false,
    "error": "Задача с номером 123214214 не существует. удалить не возможно",
    "param": {
        "id": "123214214"
    },
    "method": "DELETE"
}

запрос http://yiiapi/api/web/v1/requests/10
ответ {
    "success": true,
    "data": "удалена"
}


