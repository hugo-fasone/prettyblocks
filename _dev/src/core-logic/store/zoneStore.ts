import { ZoneState } from "../entities/PageState";
import { addBlock } from "../usecases/addBlock";
import { defineStore } from "pinia";

export const useZoneStore = defineStore("zone", {
  state: (): ZoneState => {
    return {
      availableBlocks: [],
      content: [],
    };
  },
  actions: {
    addBlock(blockId: string) {
      addBlock(this, blockId);
    },
    increment() {
      this.count++;
    },
  },
});
