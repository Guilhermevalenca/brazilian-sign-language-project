import { defineStore } from "pinia";
import User from "~/classes/User";

export default defineStore("user", {
    state: () => ({
        data: new User({}),
    }),
});