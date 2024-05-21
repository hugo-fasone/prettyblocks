export const deleteBlock = (zoneStore, blockIndex: number) => {
  const newArray = zoneStore.content.toSpliced(blockIndex, 1);
  zoneStore.content = newArray;
};
