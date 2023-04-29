import './app.css';

import { defineCustomElement } from 'vue'
import HelloWorld from './HelloWorld.ce.vue'
const HelloWorldCE = defineCustomElement(HelloWorld)

customElements.define('hello-world', HelloWorldCE)