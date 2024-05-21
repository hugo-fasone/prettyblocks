import { ZoneState } from "../entities/PageState";
import { addBlock } from "../usecases/addBlock";
import { defineStore } from "pinia";
import { moveBlock } from "../usecases/moveBlock";

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
    moveBlock(blockIndex: number, newIndex: number) {
      moveBlock(this, blockIndex, newIndex);
    },
    increment() {
      this.count++;
    },
  },
});
