export default {
    setTag(state, chosedtag) {
        // console.log("yoyoyoyoyo");
        state.chosedtag = chosedtag;
    },
    addTag(state, tags) {
        // console.log("oooo", tags);
        state.tags = state.tags ? state.tags.push(tags) : [tags];
    },
};
