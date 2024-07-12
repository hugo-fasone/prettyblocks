import { BlockContent } from "../entities/BlockContent";

export const deleteBlockById = (zoneStore, blockId: string) => {
  const blockIndex = zoneStore.content.findIndex(
    (block: BlockContent) => block.id === blockId
  );
  const newArray = zoneStore.content.toSpliced(blockIndex, 1);
  zoneStore.content = newArray;
};
