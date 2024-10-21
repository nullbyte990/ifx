FROM php:8.2.12-fpm

ARG USERNAME=developer
ARG WORKDIR=/application

RUN apt update && apt install -y curl zsh git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo "su - $USERNAME" > /root/.bashrc
RUN useradd -m -s /bin/zsh $USERNAME

WORKDIR $WORKDIR

RUN chown developer /application
USER $USERNAME

RUN bash -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)" "" --unattended
RUN echo '\
    export ZSH=/home/developer/.oh-my-zsh\n\n\
    ZSH_THEME="ys"\n\n\
    source $ZSH/oh-my-zsh.sh\n\
    ' > /home/$USERNAME/.zshrc
