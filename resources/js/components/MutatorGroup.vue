<template>
    <div>
        <input v-model="name" type="text">
        <button @click="addGroup">Add</button>
    </div>
</template>

<script>
    import gql from 'graphql-tag'

    function graphQLErrorMessages(errorsFromCatch) {
        const errors = errorsFromCatch.graphQLErrors[0]
        const messages = []

        if (errors.hasOwnProperty('functionError')) {
            const customErrors = JSON.parse(errors.functionError)
            messages.push(...customErrors.errors)
        } else {
            messages.push(errors.message)
        }

        return messages
    }

    export default {
        name: "MutatorGroup.vue",
        data() {
            return {
                name: "Test"
            }
        },
        methods: {
            addGroup() {
                const name = this.name

                this.$apollo.mutate({
                    mutation: gql`mutation($name: String!) {
                        createGroup (input: {name: $name}) {
                            id,
                            name,
                            created_at
                        }
                    }`,
                    variables: {
                        name,
                    }
                })
                    .then(data => {
                        console.log(data)
                    })
                    .catch(error => {
                        console.log(graphQLErrorMessages(error))
                    })
            }
        }
    }
</script>
