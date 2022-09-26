export default {
    setItems(state, items) {
        state.items = items;
    },
    addItems(state, items) {
        state.items = state.items.push(items);
    },
    toggleEdit(state, id) {
        state.add = null;
        state.edit = id;
    },
    toggleAdd(state, id) {
        state.add = id;
        state.edit = null;
    },
    removeOneItem(state, items) {
        state.items.splice(
            state.items.findIndex(({ id }) => id == items.id),
            1
        );
    },
    toggleOff(state) {
        state.add = null;
        state.edit = null;
    },
    setOneItem(state, item) {
        state.items[state.items.findIndex((i) => i.id == item.id)] = item;
        // commit("setDates");
    },
    setDates(state, items) {
        state.has_null = false;
        state.due_dates = [];
        state.items.map((item) => {
            if (!state.due_dates.includes(item.due_dates)) {
                state.due_dates.push(item.due_dates);
            }
        });
        // console.log(state.due_dates);
        // console.log(typeof state.due_dates[0]);
        let includedNull = state.due_dates.includes(null) ? true : false;

        if (includedNull) {
            const index = state.due_dates.indexOf(null);
            if (index > -1) {
                // only splice array when item is found
                state.due_dates.splice(index, 1); // 2nd parameter means remove one item only
                state.has_null = true;
            }
        }

        state.due_dates = state.due_dates.sort((a, b) => {
            let newA = a.replace("00:00:00", "");
            let newB = b.replace("00:00:00", "");
            return +new Date(newA) - +new Date(newB);
        });
        state.due_dates.unshift(null);
        // let a = [
        //     "2022-09-15 00:00:00",
        //     "2022-09-07 00:00:00",
        //     "2022-09-18 00:00:00",
        //     "2022-09-20 00:00:00",
        //     "2022-09-17 00:00:00",
        // ];
        // if (state.due_dates)
        //     state.due_dates = state.due_dates.sort(function (a, b) {
        //         return new Date(b.date) - new Date(a.date);
        //     });
    },
};
