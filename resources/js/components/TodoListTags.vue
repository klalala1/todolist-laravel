<template>
    <div>
        <b-form-group>
            <b-form-tags
                id="tags-with-dropdown"
                v-model="value"
                no-outer-focus
                class="mb-2"
            >
                <template v-slot="{ tags, disabled, addTag, removeTag }">
                    <ul
                        v-if="tags.length > 0"
                        class="list-inline d-inline-block mb-2"
                    >
                        <li
                            v-for="tag in tags"
                            :key="tag"
                            class="list-inline-item"
                        >
                            <b-form-tag
                                @remove="removTag(removeTag, tag)"
                                :title="tag"
                                :disabled="disabled"
                                variant="info"
                                >{{ tag }}</b-form-tag
                            >
                        </li>
                    </ul>

                    <b-dropdown size="sm" variant="outline-secondary" block>
                        <template #button-content>
                            <b-icon icon="tag-fill"></b-icon> Choose tags
                        </template>
                        <b-dropdown-form @submit.stop.prevent="() => {}">
                            <b-form-group
                                label-for="tag-search-input"
                                label-cols-md="auto"
                                class="mb-0"
                                label-size="sm"
                                :description="searchDesc"
                                :disabled="disabled"
                            >
                                <b-form-input
                                    v-model="search"
                                    id="tag-search-input"
                                    type="search"
                                    size="sm"
                                    autocomplete="off"
                                    placeholder="Tag name"
                                ></b-form-input>
                            </b-form-group>
                        </b-dropdown-form>
                        <b-dropdown-divider></b-dropdown-divider>

                        <b-button
                            class="create-tag-button"
                            @click="addTags(addTag, search)"
                        >
                            {{ search == "" ? "" : "Create Tag : " + search }}
                        </b-button>
                    </b-dropdown>
                </template>
            </b-form-tags>
        </b-form-group>
    </div>
</template>

<script>
export default {
    name: "TodoListTags",
    props: {
        chosedTag: Array,
    },
    data() {
        return {
            options: [],
            search: "",
            value: [],
        };
    },
    computed: {
        criteria() {
            // Compute the search criteria
            return this.search.trim().toLowerCase();
        },
        availableOptions() {
            const criteria = this.criteria;
            // Filter out already selected options
            const options = this.options.filter(
                (opt) => this.value.indexOf(opt) === -1
            );
            if (criteria) {
                // Show only options that match criteria
                return options.filter(
                    (opt) => opt.toLowerCase().indexOf(criteria) > -1
                );
            }
            // Show all options available
            return options;
        },
        searchDesc() {
            if (this.criteria && this.availableOptions.length === 0) {
                return "";
            }
            return "";
        },
    },
    methods: {
        async onOptionClick({ option, addTag }) {
            await addTag(option);

            this.$store.commit("tags/setTag", this.value);
            this.search = "";
        },
        async addTags(addTag, tag) {
            await addTag(tag);

            this.$store.commit("tags/setTag", this.value);
            this.search = "";
        },
        createTag(search) {
            // console.log(search);
            this.$store
                .dispatch("tags/createTag", {
                    tag: search,
                    username: this.$store.state.user.userData.username,
                })
                .then(() => {
                    this.options.push(search);
                });
            // this.search = "";
        },
        async removTag(removeTag, tag) {
            await removeTag(tag);
            this.$store.commit("tags/setTag", this.value);
        },
        deleteTag(tag) {
            // console.log("deleting => ", tag);
        },
    },
    async mounted() {
        if (this.$store.state.tags.tags === null) {
            // let userOptions = await this.$store.dispatch(
            //     "tags/getTags",
            //     this.$store.state.user.userData.username
            // );
            // if (userOptions.length > 0) {
            //     userOptions.map((tag) => {
            //         this.options.push(tag.tag_name);
            //     });
            // }
            // this.$store.commit("tags/setTags", this.options);
        } else {
            this.options = this.$store.state.tags.tags;
        }
        if (this.chosedTag) {
            this.value = this.chosedTag;
        }
    },
    updated() {},
};
</script>
<style scoped>
.form-control {
    border: none !important;
}
#tag-search-input {
    width: 100% !important;
}
.create-tag-button {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    color: black !important;
    font-size: 13px !important;
}
</style>
