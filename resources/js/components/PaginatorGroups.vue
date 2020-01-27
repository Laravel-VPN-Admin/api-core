<template>
    <div>
        <h2>Pagination Group</h2>
        <div v-if="groups">
            <div v-for="group in groups.data">
                {{ group.id }} - {{ group.name }}
            </div>
            <div class="actions">
                <button v-if="showMoreEnabled" @click="showMore">Show more</button>
            </div>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag'

    const first = 6

    export default {
        name: 'PaginatorGroups.vue',
        data: () => ({
            page: 1,
            showMoreEnabled: true,
        }),
        apollo: {
            groups: {
                query: gql`query groups($page: Int!, $first: Int!){
                    groups(page: $page, first: $first){
                        data {
                            id,
                            name
                        }
                        paginatorInfo {
                          hasMorePages
                        }
                    }
                }`,
                variables: {
                    page: 1,
                    first: first
                },
            },
        },
        methods: {
            showMore () {
                this.page++;
                this.$apollo.queries.groups.fetchMore({
                    variables: {
                        page: this.page,
                        first: first,
                    },
                    updateQuery: (previousResult, { fetchMoreResult }) => {
                        let newGroup = fetchMoreResult.groups;
                        this.showMoreEnabled = newGroup.paginatorInfo.hasMorePages;
                        return {
                            groups: {
                                __typename: previousResult.groups.__typename,
                                data: [...previousResult.groups.data, ...newGroup.data],
                                paginatorInfo: newGroup.paginatorInfo
                            },
                        }
                    },
                })
            },
        },
    }
</script>

