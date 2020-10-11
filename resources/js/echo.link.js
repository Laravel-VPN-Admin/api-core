import { ApolloLink, Observable } from 'apollo-link';
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

class EchoLink extends ApolloLink {
  constructor() {
    super();
    const token = localStorage.getItem('token');
    this.subscriptions = [];
    this.echo = new Echo({
      broadcaster: 'pusher',
      key: 'ec4590b10c250426b9d1',
      cluster: 'eu',
      disabledTransports: ['wss'],
      forceTLS: false,
      authEndpoint: `graphql/subscriptions/auth`,
      wsHost: window.location.hostname,
      wsPort: 6001,
      wssPort: 6001,
      disableStats: true,
      auth: {
        headers: {
          authorization: token ? `Bearer ${token}` : null,
        },
      },
    });
  }

  request(operation, forward) {
    return new Observable(observer => {
      // Check the result of the operation
      forward(operation).subscribe({
        next: data => {
          // If the operation has the subscription extension, it's a subscription
          const subscriptionChannel = this._getChannel(data, operation);

          if (subscriptionChannel) {
            this._createSubscription(subscriptionChannel, observer);
          } else {
            // No subscription found in the response, pipe data through
            observer.next(data);
            observer.complete();
          }
        },
      });
    });
  }

  _getChannel(data, operation) {
    return !!data.extensions &&
    !!data.extensions.lighthouse_subscriptions &&
    !!data.extensions.lighthouse_subscriptions.channels
      ? data.extensions.lighthouse_subscriptions.channels[operation.operationName]
      : null;
  }

  _createSubscription(subscriptionChannel, observer) {
    const privateChannelName = subscriptionChannel.split('private-').pop();

    if (!this.subscriptions.find(s => s.channel === subscriptionChannel)) {
      this.subscriptions.push({
        channel: subscriptionChannel,
        observer: observer,
      });
    }

    this.echo.private(privateChannelName).listen('.lighthouse-subscription', payload => {
      if (!payload.more || observer._subscription._state === 'closed') {
        this._leaveSubscription(subscriptionChannel, observer);
        return;
      }
      const result = payload.result;
      if (result) {
        observer.next({
          data: result.data,
          extensions: result.extensions,
        });
      }
    });
  }

  _leaveSubscription(channel, observer) {
    const subscription = this.subscriptions.find(s => s.channel === channel);
    this.echo.leave(channel);
    observer.complete();
    this.subscriptions = this.subscriptions.slice(this.subscriptions.indexOf(subscription), 1);
  }
}

export default EchoLink;