Table Operators (
  operator_id    BIGINT     PRIMARY KEY,   -- Telegram user ID
  username       VARCHAR,                  -- ник в Telegram
  full_name      VARCHAR,                  -- ФИО или отображаемое имя
  is_supervisor  BOOLEAN    DEFAULT FALSE, -- роль: супервайзер / обычный оператор
  joined_at      TIMESTAMP DEFAULT NOW()
);

-- таблица создается в случаи, когда пользователь ввель команду /start в Телеграмм
-- operator_id уникальный айди пользователя из Телеграмм
-- is_supervisor позволяеть разделять от обычных пользователей и от супервайзера
-- joinde_at позволяеть определять время присоединение в ланч


Table LunchSchedules (
  schedule_id    SERIAL      PRIMARY KEY, 
  name           VARCHAR     NOT NULL,           -- 
  hour           INT         NOT NULL,            
  minute         INT         DEFAULT 0,
  max_per_round  INT         NOT NULL,           -- сколько человек за одну «раздачу»
  active         BOOLEAN     DEFAULT TRUE
);

-- schedule_id = это переводится как идентификаторь расписания здесь всегда будеть сериалозванный идентификатор
-- name «Утренний сбор», «Дневной сбор» и «Ночной сбор»
-- hour час по местному времени
-- minute это колонка нужно чтобы указать сколько времени дается на ланч
-- max_per_round -- для п.5 ("бот может быть применен для очереди на личное ...")
-- Нужно для хранения временных окон, когда бот запускает новый сбор очереди

Table LunchSessions (
  session_id     SERIAL      PRIMARY KEY,
  schedule_id    INT         REFERENCES LunchSchedules(schedule_id),
  date           DATE        NOT NULL,
  status         VARCHAR(20) DEFAULT 'collecting', 
    -- 'collecting', 'notified', 'finished'
  created_at     TIMESTAMP   DEFAULT NOW()
);

-- LunchSessions = Ланч Сессии
-- session_id это тоже С.айди
-- date это колонка нужно для сохранения даты
-- status нужна для обозначения состояния Сессии
-- created_at нужно чтобы понять когда было создано данная Сессия 
-- Одна запись = один запуск сбора очереди

Table QueueEntries (
  entry_id       SERIAL      PRIMARY KEY,
  session_id     INT         REFERENCES LunchSessions(session_id),
  operator_id    BIGINT      REFERENCES Operators(operator_id),
  joined_at      TIMESTAMP   DEFAULT NOW(),
  position       INT,                        -- вычисляется автоматически: 1,2,3…
  status         VARCHAR(20) DEFAULT 'waiting'
    -- 'waiting', 'notified', 'eating', 'finished'
);

-- QueueEntries = Записи в очередь
-- Сессия нужно для отношениях к Записи в очередь
-- Оператор нужно для отношения к Записи в очерель
-- joined_at нужно чтобы взять время присоединения в очередь когда нажимають /join в Телеграме
-- position позиция очереди вычисляется автоматически: 1,2,3...
-- status нужно чтобы понять в каком состоянии находится их позиция 
-- Ожидания -- Уведомлен -- В ланче -- Закончили

