import {login, logout, register} from '@/queries/auth.gql'
import { Apollo } from '@/apollo.js'

const Plugin = {
    install (Vue, options = {}) {

        //Add $auth api methods
        Vue.prototype.$auth = {

            register(data) {
                return Apollo.mutate({
                    mutation: register,
                    variables: {
                        data: data
                    }
                })
            },

            //Attempts to log the user in with supplied credentials
            login(data) {
                return Apollo.mutate({
                    mutation: login,
                    variables: {
                        data: data
                    }
                })
            },

            //Logs the user out and clears local tokens
            logout() {
                return Apollo.mutate({
                    mutation: logout,
                })
            },
        }
    }
}

export default Plugin
