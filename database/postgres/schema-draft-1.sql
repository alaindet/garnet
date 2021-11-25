CREATE TABLE public.task_states
(
    task_state_id smallserial NOT NULL,
    name text NOT NULL,
    PRIMARY KEY (task_state_id)
);

ALTER TABLE IF EXISTS public.task_states
    OWNER to garnet;

CREATE TABLE public.user_roles
(
    user_role_id smallserial NOT NULL,
    name text NOT NULL,
    PRIMARY KEY (user_role_id)
);

ALTER TABLE IF EXISTS public.user_roles
    OWNER to garnet;
