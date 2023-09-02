/* eslint-disable no-unused-expressions */
/* eslint-disable @typescript-eslint/no-unused-expressions */
import ReactDOM from 'react-dom/client';
import { Provider } from 'react-redux';
import store from 'store';
import App from './App';

const container = document.getElementById('root');

container &&
    ReactDOM.createRoot(container).render(
        <Provider store={store}>
            <App />
        </Provider>
    );
