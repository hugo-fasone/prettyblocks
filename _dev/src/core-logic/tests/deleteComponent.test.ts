import { BlockContent } from "../entities/BlockContent";
import { CannotFindComponentError } from "../errors/CannotFindComponentError";
import { OperationNotAllowedError } from "../errors/OperationNotAllowedError";
import { createTestingPinia } from "@pinia/testing";
import oneColumnContentWithId from "./oneColumnContentWithId.json";
import { setActivePinia } from "pinia";
import { useZoneStore } from "../store/zoneStore";

describe("Delete component", () => {
  const oneColumnBlock: BlockContent = oneColumnContentWithId as BlockContent;
  beforeEach(() => {
    const pinia = createTestingPinia({
      initialState: {
        zone: {
          content: [oneColumnBlock],
        },
      },
      stubActions: false,
    });
    setActivePinia(pinia);
  });

  it("throws error when component is not found", () => {
    const zoneStore = useZoneStore();
    const failingDelete = () => zoneStore.deleteComponentById("undefinedId");
    expect(failingDelete).toThrow(
      CannotFindComponentError("undefinedId", "zone")
    );
  });

  it("throws error when component is not inside repeater and not optional", () => {
    const zoneStore = useZoneStore();
    const failingDelete = () => zoneStore.deleteComponentById("banner_intro");
    expect(failingDelete).toThrow(
      OperationNotAllowedError(
        "Delete component",
        "Non repeated and non optional components cannot be deleted"
      )
    );
  });
});
