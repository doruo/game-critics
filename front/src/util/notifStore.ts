import type { Notif } from "@/types";
import { computed, ref, type ComputedRef, type Ref } from "vue";

export const notifList: ComputedRef<Array<Notif>> = computed(() => _notifList.value);
const _notifList: Ref<Array<Notif>> = ref([]);

export function removeNotif(notifToRemove: Notif) : void {
  _notifList.value = notifList.value.filter((notif) =>
    notif.id !== notifToRemove.id
  );
}

export function addNotif(notifToAdd: Notif) : void {
  // random indispensable pour que removeNotif ai un repère de comparaison (comparer les deux objets ne fonctionne pas)
  notifToAdd.id = Math.random();
  _notifList.value.push(notifToAdd);
  
  if (notifToAdd.autoRemoved) {
      setTimeout(() => {
          removeNotif(notifToAdd);
      }, 5000);
  }
}