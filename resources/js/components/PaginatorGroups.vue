<template>
    <div>
        <h2>Pagination Group</h2>
        <div v-if="groups">
            <div v-for="group in groups.data" :key="group.id">
                {{ group.id }} - {{ group.name }}
            </div>
            <div class="actions">
                <button v-if="showMoreEnabled" @click="showMore">Show more</button>
                <button @click="refetch">refetch</button>
            </div>
        </div>
    </div>
</template>

<script>
    import gql from 'graphql-tag'

    const GroupAll = gql`
	query groups($page: Int!, $first: Int!) {
		groups(page: $page, first: $first) {
			data {
				id
				name
			}
			paginatorInfo {
				hasMorePages
			}
		}
	}
`;

    const first = 10;

    export default {
        name: 'PaginatorGroups.vue',
        data: () => ({
            page: 1,
            groups: [],
            showMoreEnabled: true,
        }),
        apollo: {
            groups: {
                query: GroupAll,
                variables: {
                    page: 1,
                    first: first
                }
            },
        },
        methods: {
            showMore() {
                this.page++;
                this.$apollo.queries.groups.fetchMore({
                    variables: {
                        page: this.page,
                        first: first,
                    },
                    updateQuery: (previousResult, {fetchMoreResult}) => {
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
            refetch() {
                this.page = 1;
                this.showMoreEnabled = true;
                this.$apollo.queries.groups.refetch()
            },
        },
    }
</script>

