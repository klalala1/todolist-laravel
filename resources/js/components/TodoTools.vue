<template>
    <div
        style="
            display: flex;
            flex-direction: row;
            margin: auto;
            margin-top: 300px;
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
                z-index: 10;
            "
        >
            <button
                v-if="$store.state.items.add != 'add'"
                class="add-task-container"
                style="position: fixed; right: calc(50% - 51px); top: 200px"
                @click="addTask('add')"
            >
                <b-icon-plus-circle class="icons"> </b-icon-plus-circle>

                <b class="add-task-text">Add task</b>
            </button>
            <AddEditTodo
                style="position: fixed; right: calc(50% - 190px); top: 200px"
                v-else-if="$store.state.items.add == 'add'"
            ></AddEditTodo
        ></span>

        <div v-for="date in this.$store.state.items.due_dates">
            <div
                class="todo-list-user"
                v-if="
                    (date != null &&
                        new Date(date.replace('00:00:00', '')) > dateNow) ||
                    (date == null && $store.state.items.has_null == true)
                "
                style=""
            >
                <b-card-group
                    style="
                        border: 1px solid rgba(0, 0, 0, 0.01);
                        border-radius: 4px;
                        padding: 20px;
                        background-color: #f0f0f0;
                        border-bottom: none;
                        border-top: none;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        align-content: center;
                    "
                >
                    <b>{{
                        date == null && $store.state.items.has_null
                            ? "No Due Date"
                            : dateFormater(date)
                    }}</b>
                    <div
                        deck
                        v-for="(item, index) in $store.state.items.items"
                        :key="(date, item, index)"
                        v-if="item.due_dates == date"
                    >
                        <b-modal
                            hide-footer
                            hide-header
                            content-class="modal-content-infoModal"
                            v-model="infoModal"
                        >
                            <div
                                style="
                                    height: calc(100% + 4rem);
                                    background-color: white;
                                    border-radius: 8px;
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    white-space: pre-line;
                                    text-align: center;
                                "
                            >
                                <b-dropdown
                                    size="lg"
                                    variant="link"
                                    toggle-class="text-decoration-none"
                                    no-caret
                                    class="todo-more-button"
                                    style="
                                        right: 14px;
                                        top: 12px;
                                        position: absolute;
                                    "
                                >
                                    <template #button-content>
                                        <b-icon-three-dots
                                            rotate="90"
                                            class="todo-edit"
                                        >
                                        </b-icon-three-dots>
                                    </template>

                                    <b-dropdown-item
                                        @click="editTodo(todoInfo.id)"
                                        >Edit</b-dropdown-item
                                    >
                                    <b-dropdown-item
                                        @click="
                                            [
                                                toggleModal(),
                                                toggleDelete(todoInfo),
                                            ]
                                        "
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
                                                    @click="
                                                        modalShow = !modalShow
                                                    "
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
                                                    >Are you sure you want to
                                                    delete
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
                                                            modalShow =
                                                                !modalShow
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
                                <span
                                    style="
                                        margin-top: 20px;
                                        font-size: 20px;
                                        font-weight: 700;
                                        inline-size: 80%;
                                        overflow-wrap: break-word;
                                    "
                                >
                                    {{ "Name : " + todoInfo.name }}</span
                                >

                                <span
                                    style="
                                        font-size: 16px;
                                        font-weight: 400;
                                        inline-size: 80%;
                                        overflow-wrap: break-word;
                                    "
                                >
                                    {{
                                        `Description :  ${
                                            todoInfo.description
                                                ? todoInfo.description
                                                : "None"
                                        }`
                                    }}
                                </span>

                                <span style="font-weight: 700">
                                    {{
                                        `Due date : ${
                                            !todoInfo.due_date
                                                ? "None"
                                                : dateFormater(
                                                      todoInfo.due_date
                                                  )
                                        }`
                                    }}
                                </span>

                                <span style="margin-bottom: 60px">
                                    {{ "Tags : "
                                    }}<span
                                        v-if="
                                            todoInfo.tags &&
                                            todoInfo.tags.length > 0
                                        "
                                    >
                                        <b-form-tag
                                            v-for="tag in todoInfo.tags"
                                            :key="tag"
                                            :title="tag"
                                            no-remove
                                            variant="info"
                                        >
                                        </b-form-tag> </span
                                    ><span v-else> none </span>
                                </span>
                            </div>
                            <b-button
                                class="todo-done-button"
                                @click="doneTodo(todoInfo.id)"
                                style="
                                    top: 21px;
                                    left: 11px;
                                    position: absolute;
                                    border: 1px solid black;
                                "
                            >
                                <b-icon-check-circle
                                    style="position: absolute"
                                    class="todo-done-icon"
                                ></b-icon-check-circle>
                                <span
                                    class="done-text"
                                    style="top: 5px !important"
                                    >Done</span
                                >
                            </b-button>
                        </b-modal>
                        <b-card
                            class="todo-list-individual"
                            v-if="item.id !== getEdit()"
                            style="
                                display: flex;
                                flex-direction: column;
                                align-content: flex-start;
                                align-items: flex-start;
                                height: 100%;
                            "
                        >
                            <b-button
                                class="todo-done-button"
                                @click="doneTodo(item.id)"
                                style="top: 10px; left: 8px; position: absolute"
                            >
                                <b-icon-check-circle
                                    style="position: absolute"
                                    class="todo-done-icon"
                                ></b-icon-check-circle>
                                <span class="done-text" style="top: 13px"
                                    >Done</span
                                >
                            </b-button>
                            <div style="margin-bottom: 40px">
                                <b-dropdown
                                    size="lg"
                                    variant="link"
                                    toggle-class="text-decoration-none"
                                    no-caret
                                    class="todo-more-button"
                                    style="
                                        right: 14px;
                                        top: 12px;
                                        position: absolute;
                                    "
                                >
                                    <template #button-content>
                                        <b-icon-three-dots
                                            rotate="90"
                                            class="todo-edit"
                                        >
                                        </b-icon-three-dots>
                                    </template>

                                    <b-dropdown-item @click="editTodo(item.id)"
                                        >Edit</b-dropdown-item
                                    >
                                    <b-dropdown-item
                                        @click="
                                            [toggleModal(), toggleDelete(item)]
                                        "
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
                                                    @click="
                                                        modalShow = !modalShow
                                                    "
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
                                                    >Are you sure you want to
                                                    delete
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
                                                            modalShow =
                                                                !modalShow
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
                            <b-list-group
                                @click="toggleInfoModal(item)"
                                style="
                                    display: flex;
                                    flex-direction: column;
                                    align-items: flex-start;
                                    cursor: pointer;
                                "
                            >
                                <b-list-group-item
                                    style="font-size: 26px; font-weight: 700"
                                    class="item-card"
                                >
                                    {{ item.name }}</b-list-group-item
                                >
                                <b-list-group-item
                                    style="font-size: 16px; font-weight: 400"
                                    class="item-card"
                                >
                                    <span
                                        v-if="item.description == null"
                                        style="opacity: 0.4"
                                        >no description</span
                                    >
                                    <span v-else> {{ item.description }}</span>
                                </b-list-group-item>

                                <span style="position: absolute; bottom: 30px">
                                    {{ "Tags : "
                                    }}<span v-if="item.tags_list.length > 0">
                                        <b-form-tag
                                            v-for="tag in item.tags_list"
                                            :key="tag"
                                            :title="tag"
                                            no-remove
                                            variant="info"
                                            >{{ tag }}</b-form-tag
                                        > </span
                                    ><span v-else> none </span>
                                </span>
                            </b-list-group>
                            <br />
                            <br />
                            <!-- <b>Due Dates </b>{{ dateFormater(item.due_dates) }}<br /> -->
                        </b-card>
                        <AddEditTodo :item="item" v-else></AddEditTodo>

                        <!-- </div> -->
                    </div></b-card-group
                >
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
                    <b class="add-task-text">Add task</b>
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
        const now = new Date();
        const today = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate()
        );

        return {
            modalShow: false,
            deleting: null,
            time: null,
            date_item: [""],
            dateNow: today,
            todoInfo: {},
            infoModal: false,
        };
    },
    props: {},
    async mounted() {
        // console.log("test");
        // this.getDates();
    },
    methods: {
        toggleInfoModal(item) {
            this.todoInfo = {
                name: item.name,
                description: item.description,
                due_date: item.due_dates,
                tags: item.tags_list,
                id: item.id,
            };

            this.infoModal = !this.infoModal;
        },
        log() {},
        addTask(date) {
            this.$store.commit("items/toggleAdd", date == null ? "none" : date);
            this.$store.commit("tags/setTag", []);
        },

        editTodo(id) {
            this.infoModal = false;
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
            this.infoModal = false;
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
            this.infoModal = false;
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
    white-space: nowrap;
    opacity: 0.7;
    color: black;
}
.add-task-container:hover .icons {
    color: #00ffb3;
}
.add-task-container:hover .add-task-text {
    color: #00ffb3;
}
.add-task-container {
    margin-top: 20px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    background-color: #ffffff;
    border: 1 !important;
    border-radius: 5px;
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
    width: 86px !important;
    font-size: 13px !important;
    background: rgb(255, 255, 255) !important;
    white-space: nowrap;
    color: black !important;
}
.add-todolist-form {
    /* border: 1px solid !important; */
    display: block;
    border-width: 1px;
    border-style: dotted;
    background-color: rgb(255, 255, 255);
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
    width: 450px;
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
.card-body {
    display: flex;
    flex-direction: column;
    align-content: flex-start;
    align-items: flex-start;
    padding: 0px !important;
    flex: 0 0 !important;
}
.list-group-item + .list-group-item {
    border-top-width: 1px !important;
}
.item-card {
    width: 262.5px;
    text-align: start;
    height: 65px;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;

    @supports (-webkit-line-clamp: 2) {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: initial;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
}
.btn-link {
    width: 100% !important;
}
.modal-content-infoModal {
    background-color: transparent !important;
    border: none !important;
    display: flex;
}
.todo-done-button:hover .done-text {
    color: #00ffb3 !important;
}
.done-text {
    position: absolute;
    left: 52px;
    top: 5px;
}
</style>
