import Alpine from 'alpinejs'
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm';
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import focus from '@alpinejs/focus'
import Tooltip from "@ryangjchandler/alpine-tooltip";
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Tribute from "tributejs";
import axios from 'axios';

window.axios = axios;

Alpine.plugin(focus)
Alpine.plugin(Tooltip);
Alpine.plugin(Clipboard);
Alpine.plugin(FormsAlpinePlugin);
Alpine.plugin(NotificationsAlpinePlugin)

window.Tribute = Tribute;
window.Alpine = Alpine

Alpine.start()

