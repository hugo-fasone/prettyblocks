import { BlockStructure } from "./../entities/BlockStructure";
import { ZoneState } from "../entities/PageState";
import { addBlock } from "../usecases/addBlock";
import { addComponent } from "../usecases/addComponent";
import { defineStore } from "pinia";
import { deleteBlock } from "../usecases/deleteBlock";
import { moveBlock } from "../usecases/moveBlock";

export const useZoneStore = defineStore("zone", {
  state: (): ZoneState => {
    return {
      availableBlocks: [],
      content: [],
    };
  },
  getters: {
    getBlockStructure: (state) => {
      return (blockId: string) => {
        return state.availableBlocks.find(
          (block: BlockStructure) => block.id === blockId
        );
      };
    },
  },
  actions: {
    addBlock(blockId: string) {
      addBlock(this, blockId);
    },
    moveBlock(blockIndex: number, newIndex: number) {
      moveBlock(this, blockIndex, newIndex);
    },
    deleteBlock(blockIndex: number) {
      deleteBlock(this, blockIndex);
    },
    addComponent(blockIndex: number, componentId: string) {
      console.debug("Hello");
      addComponent(this, blockIndex, componentId);
    },
  },
});
