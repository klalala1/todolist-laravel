<template>
    <span>
        <b-dropdown-item v-b-modal.modal-xl @click="fetchCompleted()"
            >Completed</b-dropdown-item
        >
        <b-modal id="modal-xl" size="xl" title="Completed Todos">
            <span style="display: flex; flex-direction: column">
                <span
                    v-for="todo in completed"
                    style="
                        display: flex;
                        flex-direction: row;

                        justify-content: space-between;
                    "
                >
                    <span
                        style="
                            width: 20%;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            overflow: hidden;
                        "
                    >
                        {{ `Name : ${todo.name}` }}</span
                    ><span
                        style="
                            width: 20%;
                            text-overflow: ellipsis;
                            white-space: nowrap;
                            overflow: hidden;
                        "
                    >
                        {{ `Description : ${todo.description}` }}</span
                    ><span style="width: 20%">
                        {{
                            `Completed At : ${dateFormater(todo.completed_at)}`
                        }}</span
                    ><span style="width: 20%">
                        {{
                            `Created At : ${dateFormater(
                                todo.created_at.replace("00:00:00,")
                            )}`
                        }}</span
                    ><span style="width: 20%">{{
                        ` Due Date : ${
                            todo.due_dates == null
                                ? "None"
                                : dateFormater(
                                      todo.due_dates.replace("00:00:00,")
                                  )
                        }`
                    }}</span>
                </span>

                <br
            /></span>
        </b-modal>
    </span>
</template>

<script>
export default {
    name: "Completed",
    data() {
        return { completed: [] };
    },
    methods: {
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
        fetchCompleted() {
            this.$store
                .dispatch("items/getCompleted", {
                    headers: {
                        username: this.$store.state.user.userData.username,
                        completed: "true",
                    },
                })
                .then((res) => {
                    this.completed = res.data;
                    // console.log(res);
                });
        },
    },
    mounted() {},
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style></style>
