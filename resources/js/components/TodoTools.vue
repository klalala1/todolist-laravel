<template>
    <div
        style="
            display: flex;
            flex-direction: row;
            margin: auto;
            margin-top: 200px;
            margin-left: 400px;
        "
    >
        <span
            style="
                margin-left: -200px;
                display: flex;
                flex-direction: column;
                place-content: center;
                justify-content: flex-start;
            "
        >
            <button
                v-if="$store.state.items.add != 'add'"
                class="add-task-container"
                @click="addTask('add')"
            >
                <b-icon-plus-circle class="icons"> </b-icon-plus-circle>
                <!-- <b-icon-trash class="icons"></b-icon-trash> -->
                <span class="add-task-text">Add task</span>
            </button>
            <AddEditTodo
                v-else-if="$store.state.items.add == 'add'"
            ></AddEditTodo
        ></span>
        <div v-for="date in this.$store.state.items.due_dates">
            <span>{{
                date == null && $store.state.items.has_null
                    ? "No Due Date"
                    : dateFormater(date)
            }}</span>
            <div
                class="todo-list-user"
                v-if="
                    (date == null && $store.state.items.has_null == false) ==
                    false
                "
            >
                <span
                    v-for="item in $store.state.items.items"
                    v-if="item.due_dates == date"
                >
                    <!-- <div v-for="todo in item.item"> -->
                    <!-- <hr />  -->

                    <div
                        class="todo-list-individual"
                        v-if="item.id !== getEdit()"
                        style="
                            display: flex;
                            flex-direction: column;
                            align-content: flex-start;
                            align-items: flex-start;
                        "
                    >
                        <!-- <div> -->

                        <b-button
                            class="todo-done-button"
                            @click="doneTodo(item.id)"
                        >
                            <b-icon-check-circle
                                class="todo-done-icon"
                            ></b-icon-check-circle></b-button
                        ><span>
                            <b-form-tag
                                v-for="tag in item.tags_list"
                                :key="tag"
                                :title="tag"
                                no-remove
                                variant="info"
                                >{{ tag }}</b-form-tag
                            ></span
                        >

                        <b>Name </b> {{ item.name }} <br /><b>Description</b>
                        {{ item.description }} <br />
                        <!-- <b>Due Dates </b>{{ dateFormater(item.due_dates) }}<br /> -->

                        <div style="margin-bottom: 40px">
                            <b-dropdown
                                size="lg"
                                variant="link"
                                toggle-class="text-decoration-none"
                                no-caret
                                class="todo-more-button"
                            >
                                <template #button-content>
                                    <b-icon-three-dots class="todo-edit">
                                    </b-icon-three-dots>
                                </template>
                                <b-dropdown-item @click="editTodo(item.id)"
                                    >Edit</b-dropdown-item
                                >
                                <b-dropdown-item
                                    @click="[toggleModal(), toggleDelete(item)]"
                                    >Delete</b-dropdown-item
                                >
                                <div>
                                    <b-modal
                                        hide-footer
                                        hide-header
                                        content-class="modal-content-transparent"
                                        v-model="modalShow"
                                    >
                                        <div
                                            style="
                                                width: 400px;
                                                height: 200px;
                                                background-color: white;
                                                border-radius: 8px;
                                                display: flex;
                                                flex-direction: column;
                                                align-items: center;
                                                justify-content: center;
                                            "
                                        >
                                            <b-button
                                                style="
                                                    position: absolute;
                                                    top: 20px;
                                                    left: 388px;
                                                    width: 25px;
                                                    height: 25px;
                                                    background: transparent !important;
                                                    border: none;
                                                "
                                                @click="modalShow = !modalShow"
                                            >
                                                <b-icon-x
                                                    shift-h="-8"
                                                    shift-v="8"
                                                    style="
                                                        position: absolute;
                                                        color: black;
                                                        width: 25px;
                                                        height: 25px;
                                                    "
                                                ></b-icon-x
                                            ></b-button>
                                            <span
                                                >Are you sure you want to delete
                                                <b>{{
                                                    deleting
                                                        ? deleting.name
                                                        : ""
                                                }}</b></span
                                            >
                                            <span style="margin-top: 20px"
                                                ><b-button
                                                    style="
                                                        width: 80px;
                                                        height: 35px;
                                                        font-size: 12px;
                                                        margin-right: 20px;
                                                    "
                                                    @click="
                                                        modalShow = !modalShow
                                                    "
                                                    >Cancel</b-button
                                                >
                                                <b-button
                                                    style="
                                                        width: 80px;
                                                        height: 35px;
                                                        font-size: 12px;
                                                        margin-left: 20px;
                                                    "
                                                    @click="confirmDelete()"
                                                    >Delete</b-button
                                                >
                                            </span>
                                        </div>
                                    </b-modal>
                                </div>
                            </b-dropdown>
                        </div>
                    </div>
                    <AddEditTodo :item="item" v-else></AddEditTodo>

                    <!-- </div> -->
                </span>
                <button
                    v-if="
                        ($store.state.items.add != date &&
                            $store.state.items.add != 'none') ||
                        ($store.state.items.add == date && date == null)
                    "
                    class="add-task-container"
                    @click="addTask(date)"
                >
                    <b-icon-plus-circle class="icons"> </b-icon-plus-circle>
                    <!-- <b-icon-trash class="icons"></b-icon-trash> -->
                    <span class="add-task-text">Add task</span>
                </button>
                <AddEditTodo
                    :addDate="date"
                    v-else-if="
                        ($store.state.items.add == date && date != null) ||
                        (date == null && $store.state.items.add == 'none')
                    "
                ></AddEditTodo>
            </div>
        </div>
    </div>
</template>

<script>
import TodoListTags from "./TodoListTags";
import AddEditTodo from "./AddEditTodo.vue";

export default {
    name: "TodoTools",
    components: { TodoListTags, AddEditTodo },

    data() {
        return {
            modalShow: false,
            deleting: null,
            time: null,
            date_item: [""],
        };
    },
    props: {},
    async mounted() {
        // console.log("test");
        // this.getDates();
    },
    methods: {
        addTask(date) {
            this.$store.commit("items/toggleAdd", date == null ? "none" : date);
            this.$store.commit("tags/setTag", []);
        },

        editTodo(id) {
            this.$store.commit("items/toggleEdit", id);
        },
        toggleDelete(item) {
            // this.$store.dispatch('items/deleteTodo',id);
            // this.$store.commit("items/deleteTodo", item.name);

            this.deleting = item;
        },
        toggleModal() {
            this.modalShow = !this.modalShow;
        },
        doneTodo(id) {
            this.$store.dispatch("items/doneTodo", { id });
        },
        getEdit() {
            return this.$store.state.items.edit;
        },
        async confirmDelete() {
            await this.$store.dispatch("items/deleteTodo", {
                id: this.deleting.id,
            });
            this.toggleModal();
        },
        dateFormater(strdate) {
            if (strdate == null) return null;
            strdate = strdate.replace("00:00:00", "");
            let date = new Date(strdate);
            var months = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ];
            var day = date.getDate();
            // get month from 0 to 11
            var month = date.getMonth();
            // conver month digit to month name
            month = months[month];
            var year = date.getFullYear();

            // show date in two digits
            if (day < 10) {
                day = "0" + day;
            }

            // now we have day, month and year
            // arrange them in the format we want
            return month + " " + day + ", " + year;
        },
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.add-task-text {
    opacity: 0.7;
}
.add-task-container:hover .icons {
    color: #00ffb3;
}
.add-task-container:hover .add-task-text {
    color: #00ffb3;
}
.add-task-container {
    border: 0 !important;
    background-color: transparent !important;
}
.cancel-adding-button {
    width: 70px !important;
    font-size: 13px !important;
    background: gray !important;
    margin: 0 !important;
    margin-left: 10px !important;
}
.input-todolist {
    border: 0 !important;
    box-shadow: none !important;
}
.submit-adding-button {
    width: 70px !important;
    font-size: 13px !important;
    background: rgb(255, 0, 0) !important;
    white-space: nowrap;
}
.add-todolist-form {
    /* border: 1px solid !important; */
    display: block;
    border-width: 1px;
    border-style: solid;
    border-color: grey;
    display: flex;
    padding: 20px;
    border-radius: 10px;
    flex-direction: column;
    align-content: center;
    align-items: center;
}
.input-todo-date {
    width: 80% !important;
}
.add-todo-button-row {
}
.form-control {
    white-space: nowrap !important;
}
.todo-list-user {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 800px;
    justify-content: center;
}
.todo-list-user .btn {
    /* width: 35px !important; */
    margin: 0;
    padding: 0.2rem;
    height: 30px;
}
.btn + .btn {
    margin: 0px !important;
}
.todo-list-individual {
    border: 2px solid grey;
    border-radius: 10px;
    margin-top: 10px;
    padding: 30px;
    width: 100%;
    max-width: 2000px;
    height: 250px;
    min-width: 400px;
}
.todo-list-individual + .todo-list-individual {
}
.todo-done-icon {
    width: 2em;
}
.todo-done-button:hover .todo-done-icon {
    color: #00ffb3;
}
.todo-done-button {
    color: transparent !important;
    background-color: transparent !important;
    border: none !important;
    color: grey !important;
    width: 2em !important;
}
.todo-edit-button {
    color: black !important;
    background-color: transparent !important;
    border: none !important;
}
.todo-edit-button:hover .todo-edit {
    color: #00ffb3 !important;
}
.todo-edit {
    color: rgb(75, 75, 75) !important;
    background-color: transparent !important;
}
.todo-more-button {
}
.modal-backdrop {
    opacity: 0.1 !important;
}
</style>
