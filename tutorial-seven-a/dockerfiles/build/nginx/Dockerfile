FROM nginx:latest
ARG user_name
ARG app_name
ARG user_id
ARG group_id

RUN useradd -m ${user_name} && \
    usermod -u $user_id $user_name && \
    groupmod -g $group_id $user_name && \
    chown -R ${user_id}:${group_id} /home/${user_name}/

WORKDIR /home/$user_name/$app_name


