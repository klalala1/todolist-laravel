<template>
    <div class="add-todolist-form">
        <b-form-datepicker
            id="example-datepicker"
            v-model="dateValue"
            :min="min"
            class="input-todo-date"
        ></b-form-datepicker>
        <b-list-group
            style="
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            "
        >
            <b-list-group-item style="font-size: 26px; font-weight: 700">
                <b-form-input
                    shadow-none
                    class="input-todolist"
                    id="input-todo-name"
                    v-model="todoName"
                    placeholder="Enter Name"
                    required
                >
                </b-form-input
            ></b-list-group-item>
            <b-list-group-item style="font-size: 26px; font-weight: 700">
                <b-form-input
                    shadow-none
                    class="input-todolist"
                    id="input-todo-description"
                    v-model="todoDescription"
                    placeholder="Enter Description"
                >
                </b-form-input></b-list-group-item
        ></b-list-group>

        <TodoListTags
            :chosedTag="this.item ? this.item.tags_list : []"
        ></TodoListTags>
        <span class="add-todo-button-row">
            <b-button
                class="submit-adding-button"
                :disabled="todoName == ''"
                @click="submit()"
            >
                {{
                    `${this.$store.state.items.add ? "Add task" : "Confirm"}`
                }}</b-button
            >

            <b-button class="submit-adding-button" @click="cancelAdding()"
                >Cancel</b-button
            ></span
        >
    </div>
</template>

<script>
import TodoListTags from "./TodoListTags";
import Timeselector from "vue-timeselector";
export default {
    name: "AddEditTodo",
    components: { TodoListTags, Timeselector },
    props: {
        item: Object,
        addDate: String,
    },
    data() {
        return {
            todoName: "",
            todoDescription: "",
            dateValue: null,
            userTodoList: null,
            timeValue: null,
            min: null,
        };
    },
    methods: {
        submit() {
            this.$store.state.items.add != null
                ? this.submitAdding()
                : this.submitEditing();
        },
        cancelAdding() {
            this.$store.commit("tags/setTag", []);
            this.$store.commit("items/toggleOff");
        },
        submitAdding() {
            // console.log(typeof this.timeValue);
            // console.log(this.timeValue);
            // this.dateValue = this.dateValue.setTime(this.timeValue);
            // console.log(this.timeValue);
            if (this.todoName != "") {
                this.$store
                    .dispatch("items/createItem", {
                        name: this.todoName,
                        description: this.todoDescription,
                        due_dates: this.dateValue,
                        tags_list: this.$store.state.tags.chosedtag,
                        username: this.$store.state.user.userData.username,
                    })
                    .then(() => {
                        this.cancelAdding();
                    })
                    .catch((error) => {
                        // console.log(error);
                    });
            }
        },
        submitEditing() {
            this.$store
                .dispatch("items/editTodo", {
                    name: this.todoName,
                    description: this.todoDescription,
                    due_dates: this.dateValue,
                    tags_list: this.$store.state.tags.chosedtag,
                    username: this.$store.state.user.userData.username,
                    id: this.$store.state.items.edit,
                })
                .then(() => {
                    this.cancelAdding();
                })
                .catch((error) => {
                    // console.log(error);
                });
        },
    },
    mounted() {
        const now = new Date();
        const today = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate()
        );
        const minDate = new Date(today);
        minDate.setMonth(minDate.getMonth());
        minDate.setDate(minDate.getDate());
        this.min = minDate;
        if (this.item) {
            this.todoName = this.item.name;
            this.todoDescription = this.item.description;
            this.dateValue = this.item.due_dates;
            this.tags_list = this.$store.state.tags.chosedtag;
            if (this.item.tags_list)
                this.$store.commit("tags/setTag", this.item.tags_list);
        } else if (this.addDate) {
            this.todoName = null;
            this.todoDescription = null;
            this.dateValue = this.addDate;
        }
    },
    updated() {},
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.alert {
    border: 2px solid red;
    padding: 10px;
}
.btn.disabled,
.btn:disabled {
    opacity: 0.25;
}
</style>
