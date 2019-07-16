export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.type === 'admin';

        console.log(name);
    }

    isUser() {

        return this.user.type === 'user';
    }

}
