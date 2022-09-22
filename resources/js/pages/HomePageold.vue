<template>
    <div class="testest">
        <NavbarHomePage> </NavbarHomePage>
        <p>{{ text }}</p>
        <!-- <AlertBox
            ><h1 slot="header">HEY</h1>
            <h2 slot="text">yo</h2></AlertBox
        > -->

        <TodoList :todo-items="todos"></TodoList>
        <ul>
            <!-- <li
        v-for="todo in todos"
        :key="todo.time"
        :class="{ red: !todo.completed, green: todo.completed }"
      > -->
            <li
                v-for="todo in sortItem"
                :key="todo.time"
                :style="{ color: todo.completed ? 'red' : 'green' }"
            >
                <img :src="srcUrl" />
                <span v-if="todo.completed === false">{{ todo.text }}</span>
                <span v-else> COMPLETED {{ todo.text }}</span>
                <!-- <span v-show="todo.completed === true">
          COMPLETED {{ todo.text | capitalize }}</span
        > -->
            </li>
        </ul>
        <p>{{ texts }}</p>
        <InputSave @save="addTodoItem"></InputSave>
    </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import TodoList from "../components/TodoList.vue";
import InputSave from "../components/InputSave.vue";
import AlertBox from "../components/AlertBox.vue";
import NavbarHomePage from "../components/NavbarHomePage.vue";

export default {
    name: "TestTest",
    components: { TodoList, InputSave, AlertBox, NavbarHomePage },
    filters: {
        capitalize(val) {
            return val.toUpperCase();
        },
    },
    props: {
        text: String,
    },
    data() {
        return {
            texts: "",
            color: "red",
            srcUrl: "https://via.placeholder.com/20",
            todos: [
                {
                    text: " Todo1 ",
                    time: 1,
                    completed: true,
                },
                {
                    text: " Todo2",
                    time: 2,
                    completed: true,
                },
                {
                    text: " Todo3",
                    time: 3,
                    completed: true,
                },
                {
                    text: " Todo4",
                    time: 4,
                    completed: false,
                },
                {
                    text: " Todo5",
                    time: 5,
                    completed: false,
                },
            ],
        };
    },
    computed: {
        sortItem() {
            return [...this.todos].sort((a, b) => a.time - b.time);
        },
        ...mapState(["items", "count"]),
    },
    watch: {
        texts(newVal, oldVal) {
            // console.log("old => ", oldVal, "new => ", newVal);
        },
    },
    beforeCreate() {
        // console.log("createdddd");
    },
    mounted() {
        // console.log("mountedd");
    },
    created() {
        console.log("afterCreateddd");
    },
    beforeUpdate() {
        console.log("before updatedd");
    },
    updated() {
        console.log("updateddd");
    },
    destroyed() {
        console.log("destryyyooyoy");
    },
    methods: {
        ...mapMutations(["changeCount", "addItem"]),
        ...mapActions(["addTodo"]),
        addTodoItem(text) {
            this.todos.push({
                text,
                time: Date.now(),
                completed: false,
            });
        },
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.red {
    color: red;
}
.green {
    color: green;
}
</style>
