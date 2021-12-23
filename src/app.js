import barba from "@barba/core";
import barbaPrefetch from "@barba/prefetch";

import { gsap } from "gsap";

barba.use(barbaPrefetch);

barba.hooks.enter((data) => {
  window.scrollTo(0, 0);
});

barba.init({
  debug: true,
  transitions: [
    {
      sync: true,
      leave(data) {
        const tl = gsap.timeline({ defaults: { duration: 1 } })
        tl.set(data.next.container, {position: 'absolute', left: '100%' })
        .to(data.current.container, {position: 'absolute', left: '-100%' }, 's1')
        .to(data.next.container, {position: 'absolute', left: '0%' }, 's1')
        return tl;
      },
      enter(data) {
      },
    },
  ],
});
